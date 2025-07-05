<?php
include '../includes/auth.php';
requireAdmin();
include '../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_user'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $query = "INSERT INTO users (username,email, password, role) VALUES ('$username','$email', '$password', '$role')";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_users.php?success=User created successfully");
        exit();
    } else {
        $error = "Error creating user: " . mysqli_error($conn);
    }
}

if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete']);
    $query = "DELETE FROM users WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_users.php?success=User deleted successfully");
        exit();
    } else {
        $error = "Error deleting user: " . mysqli_error($conn);
    }
}

$users = mysqli_query($conn, "SELECT * FROM users");
include '../includes/header.php';
?>

<h2>Manage Users</h2>
<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>
<form method="POST" action="">
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select class="form-control" id="role" name="role" required>
            <option value="admin">Admin</option>
            <option value="member">Member</option>
        </select>
    </div>
    <button type="submit" name="create_user" class="btn btn-primary">Create User</button>
</form>

<h3 class="mt-4">User List</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($user = mysqli_fetch_assoc($users)): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['role']; ?></td>
                <td>
                    <a href="manage_users.php?delete=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm"
                        onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>