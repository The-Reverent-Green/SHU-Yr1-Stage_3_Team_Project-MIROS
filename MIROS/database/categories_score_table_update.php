<?php

require_once __DIR__ . '/../database/db_config.php';

$categoryIDs = [1, 2, 3, 4, 5, 6, 7];
$categoryScores = [];

foreach ($categoryIDs as $categoryID) {
    $stmt = $pdo->prepare("SELECT target, score_min, score_max FROM categories WHERE Category_ID = :categoryID");
    $stmt->execute([':categoryID' => $categoryID]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$category) continue;

    $target = $category['target'];
    $score_min = $category['score_min'];
    $score_max = $category['score_max'];


    $stmt = $pdo->prepare("SELECT MAX(submission_count) as max_submissions FROM (SELECT COUNT(*) as submission_count FROM submissions WHERE Category_ID = :categoryID AND Verified = 'yes' GROUP BY User_ID) as counts");
    $stmt->execute([':categoryID' => $categoryID]);
    $max_submissions = $stmt->fetchColumn();


    $stmt = $pdo->prepare("SELECT User_ID, COUNT(*) as submission_count FROM submissions WHERE Category_ID = :categoryID AND Verified = 'yes' GROUP BY User_ID");
    $stmt->execute([':categoryID' => $categoryID]);
    $users_submissions = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    $user_scores = [];
    foreach ($users_submissions as $user_id => $submission_count) {
        if ($submission_count < $target) {
            $score = $score_min / 2;
        } elseif ($submission_count == $target) {
            $score = $score_min;
        } else {
            $score = $score_min + (($submission_count - $target) / ($max_submissions - $target)) * ($score_max - $score_min);
            $score = min($score, $score_max);
        }
        $user_scores[$user_id] = $score;
    }

    $categoryScores['Cat_' . chr(65 + $categoryID - 1)] = $user_scores;
}

foreach ($categoryScores as $category => $user_scores) {
    foreach ($user_scores as $user_id => $score) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM user_scores WHERE User_ID = :user_id");
        $stmt->execute([':user_id' => $user_id]);
        $exists = $stmt->fetchColumn() > 0;

        if ($exists) {
            $stmt = $pdo->prepare("UPDATE user_scores SET $category = :score WHERE User_ID = :user_id");
            $stmt->execute([':score' => $score, ':user_id' => $user_id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO user_scores (User_ID, $category) VALUES (:user_id, :score)");
            $stmt->execute([':user_id' => $user_id, ':score' => $score]);
        }
    }
}