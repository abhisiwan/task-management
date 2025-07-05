<?php
include '../includes/auth.php';
requireAdmin();
include '../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $assigned_user_id = mysqli_real_escape_string($conn, $_POST['assigned_user_id']);

    $query = "INSERT INTO tasks (title, assigned_user_id) VALUES ('$title', '$assigned_user_id')";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_tasks.php?success=Task created successfully");
        exit();
    } else {
        $error = "Error creating task: " . mysqli_error($conn);
    }
}

$users = mysqli_query($conn, "SELECT * FROM users");
include '../includes/header.php';
?>

<h2>Create Task</h2>
<?php if (isset($error)): ?>
<div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>
<form method="POST" action="">
    <div class="mb-3">
        <label for="title" class="form-label">Task Title</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>
    <div class="mb-3">
        <label for="assigned_user_id" class="form-label">Assign To</label>
        <select class="form-control" id="assigned_user_id" name="assigned_user_id" required>
            <?php while ($user = mysqli_fetch_assoc($users)): ?>
            <option value="<?php echo $user['id']; ?>"><?php echo $user['username']; ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Create Task</button>
</form>

<?php include '../includes/footer.php'; ?>