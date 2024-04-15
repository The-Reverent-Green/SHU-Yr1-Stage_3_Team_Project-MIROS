<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function unread_notifications() {
    require_once __DIR__ . '/../database/db_config.php';
    try {


        $get_unseen_notifications_from_my_team = "SELECT submissions.Description as message, user.First_Name as First_name
        FROM submissions
        INNER JOIN user 
        ON submissions.User_ID = user.User_ID
        WHERE submissions.seen = 0
        AND user.User_ID IN (SELECT User_ID FROM user WHERE Reports_To = :supervisor_id);";

        $stmt = $pdo->prepare($get_unseen_notifications_from_my_team);
        
        $stmt->bindParam(':supervisor_id', $_SESSION["id"], PDO::PARAM_INT);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['notification_count'] = count($results);

        return json_encode($results);

    } catch (PDOException $e) {
        return 'Error: ' . $e->getMessage();
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'notifications') {
    echo unread_notifications();
    exit;
}
