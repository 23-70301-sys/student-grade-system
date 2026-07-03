<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'] ?? 'Admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="cssstyle.css">
</head>
<body class="dashboard-page">

<nav class="topnav">
    <span class="topnav-brand">🎓 Student Grade Management System</span>
</nav>

<div class="dashboard-container">

    <header class="dashboard-header">
        <div>
            <h2>Dashboard</h2>
            <p class="dashboard-subtitle">
                Welcome back, <strong><?= htmlspecialchars($username) ?></strong>
            </p>
        </div>

        <form action="logout.php" method="POST" class="logout-form">
            <button type="submit" class="logout-btn">Log Out</button>
        </form>
    </header>

    <section class="welcome-card">
        <h3>👋 Hello, <?= htmlspecialchars($username) ?>!</h3>
        <p>
            Manage student records, monitor grades, and keep academic
            information organized from one place.
        </p>
    </section>

    <section class="dashboard-stats">
        <div class="stat-card">
            <span class="stat-number">1</span>
            <span class="stat-label">Available Module</span>
        </div>

        <div class="stat-card">
            <span class="stat-number">24/7</span>
            <span class="stat-label">System Access</span>
        </div>

        <div class="stat-card">
            <span class="stat-number">✓</span>
            <span class="stat-label">Administrator Mode</span>
        </div>
    </section>

    <section class="dashboard-actions">
        <a href="grades.php" class="action-card">
            <span class="action-title">📘 Grade Management</span>
            <span class="action-desc">
                View, search, edit, and export student grade records.
            </span>
        </a>
    </section>

</div>

</body>
</html>