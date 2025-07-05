<?php
session_start();

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function isAdmin()
{
    return isLoggedIn() && $_SESSION['role'] === 'admin';
}

function requireLogin()
{
    if (!isLoggedIn()) {
        header("Location: ../login.php");
        exit();
    }
}

function requireAdmin()
{
    if (!isAdmin()) {
        header("Location: ../login.php");
        exit();
    }
}
