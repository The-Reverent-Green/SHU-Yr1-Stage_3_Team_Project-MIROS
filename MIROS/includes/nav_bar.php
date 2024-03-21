<link rel="stylesheet" href="../css/nav_bar.css">
<ul class="nav nav-pills nav-fill <?php echo isset($_SESSION['role']) && $_SESSION['role'] === 'admin' ? 'admin-mode' : ''; ?>">
    <li class="nav-item">
        <a class="nav-link <?php echo isCurrentPage('index.php') ? 'active' : ''; ?>" href="index.php">Home</a>
    </li>
    <?php if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true): ?>
        <li class="nav-item">
            <a class="nav-link <?php echo isCurrentPage('register_user.php') ? 'active' : ''; ?>" href="register_user.php">Create Account</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo isCurrentPage('contact.php') ? 'active' : ''; ?>" href="contact.php">Contact</a>
        </li>
        <li class="nav-item">
            <a href="login.php" class="btn btn-warning">Login</a>
        </li>
    <?php else: ?>
        <li class="nav-item">
            <a class="nav-link <?php echo isCurrentPage('create_submission.php') ? 'active' : ''; ?>" href="create_submission.php">Make Submission</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo isCurrentPage('profile.php') ? 'active' : ''; ?>" href="profile.php">Profile</a>
        </li>
       
        <?php if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin"): ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" aria-haspopup="true" aria-expanded="false">Admin Panel</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item <?php echo isCurrentPage('all_users.php') ? 'active' : ''; ?>" href="all_users.php">All Users</a>
                    <a class="dropdown-item <?php echo isCurrentPage('assign_roles.php') ? 'active' : ''; ?>" href="assign_roles.php">Assign</a>
                    <a class="dropdown-item <?php echo isCurrentPage('contact_admin_open.php') ? 'active' : ''; ?>" href="contact_admin_open.php">Contact Inquiries</a>
                    <a class="dropdown-item <?php echo isCurrentPage('admin_dashboard.php') ? 'active' : ''; ?>" href="admin_dashboard.php">Admin Dashboard</a>
                    <a class="dropdown-item <?php echo isCurrentPage('admin_shutdown.php') ? 'active' : ''; ?>" href="admin_shutdown.php">Shutdown</a>
                </div>
            </li>
        <?php endif; ?>
        <li class="nav-item">
            <a href="logout.php" class="btn btn-outline-warning">Logout</a>
        </li>
    <?php endif; ?>
</ul>
<link rel="stylesheet" href="../css/bootstrap.css">

<?php
function isCurrentPage($page) {
    $currentPage = basename($_SERVER['PHP_SELF']);
    return $currentPage === $page;
}
?>
