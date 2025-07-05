<?php
include '../includes/auth.php';
requireAdmin();
include '../config/db_connect.php';

if (!isset($_GET['id'])) {
    header("Location: manage_tasks.php?error=No task ID provided");
    exit();
}

$task_id = mysqli_real_escape_string($conn, $_GET['id']);

$query = "SELECT * FROM tasks WHERE id = $task_id";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) == 0) {
    header("Location: manage_tasks.php?error=Task not found");
    exit();
}
$task = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $assigned_user_id = mysqli_real_escape_string($conn, $_POST['assigned_user_id']);

    $query = "UPDATE tasks SET title = '$title', assigned_user_id = '$assigned_user_id' WHERE id = $task_id";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_tasks.php?success=Task updated successfully");
        exit();
    } else {
        $error = "Error updating task: " . mysqli_error($conn);
    }
}

$users = mysqli_query($conn, "SELECT * FROM users");

include '../includes/header.php';
?>

<h2>Edit Task</h2>
<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>
<form method="POST" action="">
    <div class="mb-3">
        <label for="title" class="form-label">Task Title</label>
        <input type="text" class="form-control" id="title" name="title"
            value="<?php echo htmlspecialchars($task['title']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="assigned_user_id" class="form-label">Assign To</label>
        <select class="form-control" id="assigned_user_id" name="assigned_user_id" required>
            <?php while ($user = mysqli_fetch_assoc($users)): ?>
                <option value="<?php echo $user['id']; ?>"
                    <?php echo $user['id'] == $task['assigned_user_id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($user['username']); ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update Task</button>
    <a href="manage_tasks.php" class="btn btn-secondary">Cancel</a>
</form>

<?php include '../includes/footer.php'; ?>