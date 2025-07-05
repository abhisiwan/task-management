<?php
include '../includes/auth.php';
requireAdmin();
include '../config/db_connect.php';

$filter_user = isset($_GET['user_id']) ? mysqli_real_escape_string($conn, $_GET['user_id']) : '';
$filter_status = isset($_GET['status']) ? mysqli_real_escape_string($conn, $_GET['status']) : '';

$query = "SELECT tasks.*, users.username FROM tasks LEFT JOIN users ON tasks.assigned_user_id = users.id WHERE 1=1";
if ($filter_user) {
    $query .= " AND tasks.assigned_user_id = '$filter_user'";
}
if ($filter_status) {
    $query .= " AND tasks.status = '$filter_status'";
}
$tasks = mysqli_query($conn, $query);

if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete']);
    $query = "DELETE FROM tasks WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_tasks.php?success=Task deleted successfully");
        exit();
    } else {
        $error = "Error deleting task: " . mysqli_error($conn);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $task_id = mysqli_real_escape_string($conn, $_POST['task_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $query = "UPDATE tasks SET status = '$status' WHERE id = $task_id";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_tasks.php?success=Task status updated");
        exit();
    } else {
        $error = "Error updating task: " . mysqli_error($conn);
    }
}

$users = mysqli_query($conn, "SELECT * FROM users");
include '../includes/header.php';
?>

<h2>Manage Tasks</h2>
<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>
<a href="assign_task.php" class="btn btn-primary mb-3">Create New Task</a>

<form method="GET" action="" class="mb-3">
    <div class="row">
        <div class="col-md-4">
            <select name="user_id" class="form-control">
                <option value="">All Users</option>
                <?php while ($user = mysqli_fetch_assoc($users)): ?>
                    <option value="<?php echo $user['id']; ?>" <?php echo $filter_user == $user['id'] ? 'selected' : ''; ?>>
                        <?php echo $user['username']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-4">
            <select name="status" class="form-control">
                <option value="">All Statuses</option>
                <option value="open" <?php echo $filter_status == 'open' ? 'selected' : ''; ?>>Open</option>
                <option value="in-progress" <?php echo $filter_status == 'in-progress' ? 'selected' : ''; ?>>In Progress
                </option>
                <option value="in-review" <?php echo $filter_status == 'in-review' ? 'selected' : ''; ?>>In Review
                </option>
                <option value="pending" <?php echo $filter_status == 'pending' ? 'selected' : ''; ?>>Pending</option>
                <option value="completed" <?php echo $filter_status == 'completed' ? 'selected' : ''; ?>>Completed
                </option>
            </select>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Assigned To</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($task = mysqli_fetch_assoc($tasks)): ?>
            <tr>
                <td><?php echo $task['id']; ?></td>
                <td><?php echo $task['title']; ?></td>
                <td><?php echo $task['username'] ? $task['username'] : 'Unassigned'; ?></td>
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
                            <option value="completed" <?php echo $task['status'] == 'completed' ? 'selected' : ''; ?>>
                                Completed</option>
                        </select>
                        <input type="hidden" name="update_status" value="1">
                    </form>
                </td>
                <td>
                    <a href="edit_task.php?id=<?php echo $task['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="manage_tasks.php?delete=<?php echo $task['id']; ?>" class="btn btn-danger btn-sm"
                        onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>