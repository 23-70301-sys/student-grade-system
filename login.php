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
            $params = session_get_cookie_params();
            setcookie(session_name(), session_id(), [
                'expires'  => time() + (30 * 24 * 60 * 60),
                'path'     => $params['path'],
                'domain'   => $params['domain'],
                'secure'   => $params['secure'],
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
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
    <title>Login &middot; Student Grade Management System</title>
    <link rel="stylesheet" href="css/cssstyle.css">
</head>
<body class="login-page">

<div class="login-container">

    <aside class="login-aside">
        <div class="login-brand">
            <span class="seal">SG</span>
            <div class="login-brand-name">
                Student Grade
                <span>Management System</span>
            </div>
        </div>

        <div class="login-aside-copy">
            <h1>Every grade, properly kept.</h1>
            <p>Sign in to review class standings, track student performance, and keep records where they belong &mdash; in one place.</p>
        </div>

        <p class="login-aside-foot">BSIT Laboratory Project &middot; Authentication Module</p>
    </aside>

    <div class="login-form-side">
        <h2>Welcome back</h2>
        <p class="login-lede">Enter your credentials to access the dashboard.</p>

        <?php if ($loginError): ?>
            <p class="login-error"><?= htmlspecialchars($loginError) ?></p>
        <?php endif; ?>

        <form id="loginForm" action="login.php" method="POST" novalidate>

            <div class="form-group">
                <label id="username-label" for="username">Username</label>
                <input type="text" id="username" name="username" aria-labelledby="username-label" autocomplete="username">
                <span id="usernameError" class="field-error" role="alert"></span>
            </div>

            <div class="form-group">
                <label id="password-label" for="password">Password</label>
                <div class="pwd-container">
                    <input type="password" id="password" name="password" aria-labelledby="password-label" autocomplete="current-password">
                    <button type="button" id="togglePassword" class="toggle-btn" aria-label="Show password">Show</button>
                </div>
                <span id="passwordError" class="field-error" role="alert"></span>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="remember_me" name="remember_me">
                <label for="remember_me">Remember me for 30 days</label>
            </div>

            <button type="submit" id="submitBtn" class="login-btn">Log In</button>

        </form>

        <p class="login-demo-note">Demo credentials &mdash; <code>admin</code> / <code>admin123</code></p>
    </div>

</div>

<script src="js/jsapp.js"></script>
</body>
</html>
