<?php
include 'includes/auth.php';
include 'includes/header.php';

if (isLoggedIn()) {
    if (isAdmin()) {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: member/dashboard.php");
    }
    exit();
}
?>

<h1>Welcome to Task Management System</h1>
<p>Please <a href="login.php">login</a> to continue.</p>

<?php include 'includes/footer.php'; ?>