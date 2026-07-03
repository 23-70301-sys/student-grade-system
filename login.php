<?php
session_start();

const ADMIN_USERNAME = 'admin';
const ADMIN_PASSWORD = 'admin123';

$loginError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $rememberMe = isset($_POST['remember_me']);

    if ($username === ADMIN_USERNAME && $password === ADMIN_PASSWORD) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;

        if ($rememberMe) {
            setcookie(session_name(), session_id(), time() + (30 * 24 * 60 * 60), "/");
        }

        header("Location: dashboard.php");
        exit();
    } else {
        $loginError = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="cssstyle.css">
</head>
<body>

<div class="login-container">
    <h2>Account Login</h2>
    <?php if ($loginError): ?>
        <p class="login-error"><?= htmlspecialchars($loginError) ?></p>
    <?php endif; ?>
    <form id="loginForm" action="login.php" method="POST">
        
        <div class="form-group">
            <label id="username-label" for="username">Username</label>
            <input type="text" id="username" name="username" aria-labelledby="username-label" required autocomplete="username">
        </div>

        <div class="form-group">
            <label id="password-label" for="password">Password</label>
            <div class="pwd-container">
                <input type="password" id="password" name="password" aria-labelledby="password-label" required autocomplete="current-password">
                <button type="button" id="togglePassword" class="toggle-btn" aria-label="Show password">Show</button>
            </div>
        </div>

        <div class="checkbox-group">
            <input type="checkbox" id="remember_me" name="remember_me">
            <label for="remember_me">Remember Me</label>
        </div>

        <button type="submit" id="submitBtn" class="login-btn">Login</button>
        
    </form>
</div>

<script src="jsapp.js"></script>
</body>
</html>