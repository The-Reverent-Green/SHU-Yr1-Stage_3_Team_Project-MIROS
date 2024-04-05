<?php

require_once __DIR__ . '/../database/db_config.php';

// Get target, score_min, and score_max from categories table for Category_ID 1
$stmt = $pdo->prepare("SELECT target, score_min, score_max FROM categories WHERE Category_ID = 2");
$stmt->execute();
$category = $stmt->fetch(PDO::FETCH_ASSOC);
$target = $category['target'];
$score_min = $category['score_min'];
$score_max = $category['score_max'];

// Get the highest count of occurrences for Category_ID in the submissions table
$stmt = $pdo->prepare("SELECT MAX(submission_count) as max_submissions FROM (SELECT COUNT(*) as submission_count FROM submissions WHERE Category_ID = 2 GROUP BY User_ID) as counts");
$stmt->execute();
$max_submissions = $stmt->fetchColumn();

// Get the count of submissions for each user for Category_ID 2
$stmt = $pdo->prepare("SELECT User_ID, COUNT(*) as submission_count FROM submissions WHERE Category_ID = 2 GROUP BY User_ID");
$stmt->execute();
$users_submissions = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

// Step 2: Implement the scoring algorithm in PHP

$user_scores = [];
foreach ($users_submissions as $user_id => $submission_count) {
    if ($submission_count == 0) {
        $score = 0;
    } elseif ($submission_count < $target) {
        $score = $score_min / 2;
    } elseif ($submission_count == $target) {
        $score = $score_min;
    } else {
        $score = $score_min + (($submission_count - $target) / ($max_submissions - $target)) * ($score_max - $score_min);
        $score = min($score, $score_max);
    }
    $user_scores[$user_id] = $score;
}

// Step 3: Update the user_scores table with the calculated scores

foreach ($user_scores as $user_id => $score) {
    // Check if the user already has a score record
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM user_scores WHERE User_ID = :user_id");
    $stmt->execute([':user_id' => $user_id]);
    $exists = $stmt->fetchColumn() > 0;

    if ($exists) {
        // Update the existing record
        $stmt = $pdo->prepare("UPDATE user_scores SET Cat_B = :score WHERE User_ID = :user_id");
        $stmt->execute([':score' => $score, ':user_id' => $user_id]);
    } else {
        // Insert a new record
        $stmt = $pdo->prepare("INSERT INTO user_scores (User_ID, Cat_B) VALUES (:user_id, :score)");
        $stmt->execute([':user_id' => $user_id, ':score' => $score]);
    }
}

echo "All category B Scores have been updated successfully.";
?>