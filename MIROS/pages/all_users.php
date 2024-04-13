<?php
require_once __DIR__ . '/../database/db_config.php';

function getUsersByRole($pdo, $role = null) {
    $params = [];
    $sql = "SELECT User_ID, Username, First_Name, Last_Name, Date_of_birth, Email, account_status FROM user";
    
    if ($role !== null) {
        $sql .= " WHERE ROLE = :role";
        $params = [':role' => $role];
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    if (isset($_POST['user_id'], $_POST['new_status'])) {
        $userId = $_POST['user_id'];
        $newStatus = $_POST['new_status'];

        $stmt = $pdo->prepare("UPDATE user SET account_status = :new_status WHERE User_ID = :user_id");
        $stmt->execute([':new_status' => $newStatus, ':user_id' => $userId]);

        echo json_encode(['success' => true]);
        exit;
    }
    
    if (isset($_POST['role'])) {
        echo json_encode(getUsersByRole($pdo, $_POST['role']));
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manager Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../includes/render_nav.js"></script>
    
</head>
<body>
    <?php require_once __DIR__ . '/../includes/header.php'; ?>
    <?php require_once __DIR__ . '/../includes/header.php';?>
        <nav id="navbar">Loading Navigation bar...</nav>
    <div class="wrapper">
        <form id="roleFilterForm">
            <label for="roleSelect">Filter by role:</label>
            <select id="roleSelect" name="role">
                <option value="">All Roles</option>
                <option value="Research Officer">Research Officer</option>
                <option value="Supervisor">Supervisor</option>
                <option value="Top Manager">Top Managers</option>
            </select>
            <button type="submit">Filter</button>
        </form>

        <table id="usersTable" class="table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Date of Birth</th>
                    <th>Email</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <script>
        document.getElementById('roleFilterForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const role = document.getElementById('roleSelect').value;
            
            fetch('', { 
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'role=' + encodeURIComponent(role)
            })
            .then(response => response.json())
            .then(users => {
                const tableBody = document.getElementById('usersTable').querySelector('tbody');
                tableBody.innerHTML = ''; 
                
                users.forEach(user => {
                    const row = tableBody.insertRow();
                    const statusButton = user.account_status === 'active' 
                        ? `<button class="status-btn" data-user-id="${user.User_ID}" data-status="deactivated">Deactivate</button>` 
                        : `<button class="status-btn" data-user-id="${user.User_ID}" data-status="active">Activate</button>`;
                    
                    row.innerHTML = `
                        <td>${user.Username}</td>
                        <td>${user.First_Name}</td>
                        <td>${user.Last_Name}</td>
                        <td>${user.Date_of_birth}</td>
                        <td>${user.Email}</td>
                        <td>${statusButton}</td>
                    `;
                });
            })
            .catch(error => console.error('Error:', error));
        });

        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('status-btn')) {
                const userId = event.target.getAttribute('data-user-id');
                const newStatus = event.target.getAttribute('data-status');

                fetch('', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `user_id=${userId}&new_status=${newStatus}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        event.target.textContent = newStatus === 'active' ? 'Deactivate' : 'Activate';
                        event.target.setAttribute('data-status', newStatus === 'active' ? 'deactivated' : 'active');
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    </script>
</body>
</html>
