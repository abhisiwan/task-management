<?php
include '../includes/auth.php';
requireLogin();
include '../config/db_connect.php';

$user_id = $_SESSION['user_id'];
$tasks = mysqli_query($conn, "SELECT * FROM tasks WHERE assigned_user_id = $user_id");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $task_id = mysqli_real_escape_string($conn, $_POST['task_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $query = "UPDATE tasks SET status = '$status' WHERE id = $task_id AND assigned_user_id = $user_id";
    if (mysqli_query($conn, $query)) {
        header("Location: dashboard.php?success=Task status updated");
        exit();
    } else {
        $error = "Error updating task: " . mysqli_error($conn);
    }
}

include '../includes/header.php';
?>

<h2>Member Dashboard</h2>
<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>
<h3>Your Tasks</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($task = mysqli_fetch_assoc($tasks)): ?>
            <tr>
                <td><?php echo $task['id']; ?></td>
                <td><?php echo $task['title']; ?></td>
                <td>
                    <form method="POST" action="">
                        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                        <select name="status" onchange="this.form.submit()">
                            <option value="open" <?php echo $task['status'] == 'open' ? 'selected' : ''; ?>>Open</option>
                            <option value="in-progress" <?php echo $task['status'] == 'in-progress' ? 'selected' : ''; ?>>In
                                Progress</option>
                            <option value="in-review" <?php echo $task['status'] == 'in-review' ? 'selected' : ''; ?>>In
                                Review</option>
                            <option value="pending" <?php echo $task['status'] == 'pending' ? 'selected' : ''; ?>>Pending
                            </option>
                        </select>
                        <input type="hidden" name="update_status" value="1">
                    </form>
                </td>
                <td><?php echo $task['status']; ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>