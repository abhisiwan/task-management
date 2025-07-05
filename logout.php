<?php
include 'includes/auth.php';
session_destroy();
header("Location: login.php?success=Logged out successfully");
exit();