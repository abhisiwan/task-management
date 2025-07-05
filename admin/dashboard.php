<?php
include '../includes/auth.php';
requireAdmin();
include '../config/db_connect.php';
include '../includes/header.php';
?>

<h2 class="py-2"><?php
                    if (isLoggedIn()) {
                        if (isAdmin()) {
                            echo 'Hi, ' . $_SESSION['username'] . ' 🌟👋';
                        }
                    }
                    ?></h2>
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Manage Users</h5>
                <p class="card-text">Create, edit, or delete users.</p>
                <a href="manage_users.php" class="btn btn-primary">Go to Users</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Manage Tasks</h5>
                <p class="card-text">Create, edit, or assign tasks.</p>
                <a href="manage_tasks.php" class="btn btn-primary">Go to Tasks</a>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>