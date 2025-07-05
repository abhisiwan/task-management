<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="../css/styles.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="../index.php">Task Management</a>
            <div class="navbar-nav">
                <?php if (isLoggedIn()): ?>
                    <?php if (isAdmin()): ?>
                        <a class="nav-link" style="color:white" href="../admin/dashboard.php">Admin Dashboard</a>
                        <a class="nav-link" style="color:white" href="../admin/manage_users.php">Manage Users</a>
                        <a class="nav-link" style="color:white" href="../admin/manage_tasks.php">Manage Tasks</a>
                    <?php else: ?>
                        <a class="nav-link" style="color:white" href="../member/dashboard.php"><span
                                class="text-warning"><?php echo ucfirst($_SESSION['username']) . ',' ?></span>
                            Member
                            Dashboard</a>
                    <?php endif; ?>
                    <a class="nav-link" style="color:white" href="../logout.php">Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <div class="container mt-4">