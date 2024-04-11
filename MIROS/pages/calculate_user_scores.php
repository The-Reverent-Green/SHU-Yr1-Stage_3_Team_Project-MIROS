
<?php require_once __DIR__ . '/../database/db_config.php'; 

function calculateAndPopulateUserScores($pdo, $userId) {
    $scores = [
        'Score_A' => 0,
        'Score_B' => 0,
        'Score_C' => 0,
        'Score_D' => 0,
        'Score_E' => 0,
        'Score_F' => 0,
        'Score_G' => 0,
        'Total_Score' => 0
    ];

    for ($category = 'A'; $category <= 'G'; $category++) {
        $stmt = $pdo->prepare("SELECT SUM(score) FROM submissions WHERE User_ID = :userId AND Category_ID = (SELECT Category_ID FROM categories WHERE Category_Name = :categoryName)");
        $stmt->execute([':userId' => $userId, ':categoryName' => 'Category ' . $category]);
        $scores['Score_' . $category] = (int) $stmt->fetchColumn();
        $scores['Total_Score'] += $scores['Score_' . $category];
    }

    $stmt = $pdo->prepare("SELECT UserScore_ID FROM user_scores WHERE User_ID = :userId");
    $stmt->execute([':userId' => $userId]);
    $userScoreId = $stmt->fetchColumn();

    if ($userScoreId) {
        $updateStmt = $pdo->prepare("UPDATE user_scores SET Score_A = :Score_A, Score_B = :Score_B, Score_C = :Score_C, Score_D = :Score_D, Score_E = :Score_E, Score_F = :Score_F, Score_G = :Score_G, Total_Score = :Total_Score WHERE UserScore_ID = :UserScore_ID");
        $scores[':UserScore_ID'] = $userScoreId;
        $updateStmt->execute($scores);
    } else {
        $insertStmt = $pdo->prepare("INSERT INTO user_scores (User_ID, Score_A, Score_B, Score_C, Score_D, Score_E, Score_F, Score_G, Total_Score) VALUES (:userId, :Score_A, :Score_B, :Score_C, :Score_D, :Score_E, :Score_F, :Score_G, :Total_Score)");
        $scores[':userId'] = $userId;
        $insertStmt->execute($scores);
    }
}

calculateAndPopulateUserScores($pdo, 1); 

function getAllResearchOfficerUserIds($pdo) {
    $stmt = $pdo->prepare("SELECT User_ID FROM user WHERE ROLE = 'Research Officer'");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
}

$researchOfficerIds = getAllResearchOfficerUserIds($pdo);

foreach ($researchOfficerIds as $userId) {
    calculateAndPopulateUserScores($pdo, $userId);
}
?>