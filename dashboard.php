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
    <title>Dashboard &middot; Student Grade Management System</title>
    <link rel="stylesheet" href="css/cssstyle.css">
</head>
<body class="dashboard-page">

<div class="dashboard-container">
    <header class="dashboard-header">
        <div class="header-identity">
            <span class="seal">SG</span>
            <div>
                <h2>Dashboard</h2>
                <p class="dashboard-subtitle">Welcome back, <?= htmlspecialchars(ucfirst($username)) ?></p>
            </div>
        </div>
        <form action="logout.php" method="POST" class="logout-form">
            <button type="submit" class="logout-btn">Log Out</button>
        </form>
    </header>

    <section class="dashboard-actions">
        <a href="grades.php" class="action-card">
            <span class="action-title">Grade Management</span>
            <span class="action-desc">View, search, sort, and export student grade records for the current class.</span>
        </a>
    </section>
</div>

</body>
</html>
