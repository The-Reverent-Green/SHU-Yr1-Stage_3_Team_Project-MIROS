<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../css/nav_bar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<ul class="nav nav-pills nav-fill <?php echo isset($_SESSION['role']) && $_SESSION['role'] === 'admin' ? 'admin-mode' : ''; ?>">
    <li class="nav-item">
        <a class="nav-link <?php echo isCurrentPage('index.php') ? 'active' : ''; ?>" href="index.php">Home</a>
    </li>
    <?php if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true): ?>
        <li class="nav-item">
            <a class="nav-link <?php echo isCurrentPage('register_user.php') ? 'active' : ''; ?>" href="register_user.php">Create Account</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo isCurrentPage('contact_guest.php') ? 'active' : ''; ?>" href="contact_guest.php">Contact</a>
        </li>
        <li class="nav-item">
            <a href="login.php" class="btn btn-warning">Login</a>
        </li>
    <?php else: ?>
        <li class="nav-item">
            <a class="nav-link <?php echo isCurrentPage('profile.php') ? 'active' : ''; ?>" href="profile.php">Profile</a>
        </li>

        <?php if (isset($_SESSION["role"]) && $_SESSION["role"] === "Top Manager"): ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" aria-haspopup="true" aria-expanded="false">Management Panel</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item <?php echo isCurrentPage('management_dashboard.php') ? 'active' : ''; ?>" href="management_dashboard.php">Dashboard</a>
                    <a class="dropdown-item <?php echo isCurrentPage('research.php') ? 'active' : ''; ?>" href="research.php">Published Research</a>
                    <a class="dropdown-item <?php echo isCurrentPage('preformance.php') ? 'active' : ''; ?>" href="officers_overview.php">Preformance</a>
                </div>
            </li>
        <?php endif; ?>

        <?php if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin"): ?>
            <li class="nav-item">
            <a class="nav-link <?php echo isCurrentPage('create_submission.php') ? 'active' : ''; ?>" href="create_submission.php">Make Submission</a>
            </li>
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
<link rel="stylesheet" href="../css/nav_bar.css">
<?php
function isCurrentPage($page) {
    $currentPage = basename($_SERVER['PHP_SELF']);
    return $currentPage === $page;
}
?>

