<?php
session_start();

// Redirect to dashboard if already logged in, otherwise send to login page
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
} else {
    header('Location: login.php');
    exit;
}
?>