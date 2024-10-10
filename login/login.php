<?php
/**
 * LOGIN SCRIPT
 */

// Config laden
require_once('../config.php');

// Set the session lifetime to 12 hours (43200 seconds)
$session_lifetime = 12 * 60 * 60;

// Set session cookie parameters (lifetime, path, domain, secure, httponly)
session_set_cookie_params([
    'lifetime' => $session_lifetime,
    'path' => '/',
    'domain' => '', // Use your domain here if needed
    'secure' => isset($_SERVER['HTTPS']), // True if HTTPS is used
    'httponly' => true, // Prevent JavaScript access to the cookie
    'samesite' => 'Lax' // Prevent cross-site requests
]);

// Start session management
session_name(SESSIONCOOKIE_NAME); // Name des session cookies - muss VOR session_start() passieren
session_start(); // Sessionzugriff aktivieren

// Define a session inactivity timeout (to limit the length of inactivity allowed)
$inactivity_timeout = 30 * 60; // 30 minutes in seconds

// Update session garbage collection max lifetime
ini_set('session.gc_maxlifetime', $session_lifetime);

// Dummy credentials
$valid_username = 'Schnödögürügönggöng';
$hashed_password = '$2y$10$3ZiAgXBw4IwFhjhbrS/jxem0CEnRdFIzhbZymWkwZ77QspMS2NwZu'; // Password is: DuHalbschue@420

// Check if the user submitted the login form
if (isset($_POST['username']) && isset($_POST['password'])) {
    $isPasswordCorrect = password_verify($_POST['password'], $hashed_password); 

    if ($_POST['username'] === $valid_username && $isPasswordCorrect) {
        // Correct login: store session data
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['logintime'] = time();
        $_SESSION['userip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['useragent'] = $_SERVER['HTTP_USER_AGENT'];
    } else {
        $hasError = true;
        $errorMessages[] = 'Benutzername oder Passwort stimmt nicht';
    }
}

// Check if user is already logged in
$isLoggedIn = false;
if (isset($_SESSION['username']) && isset($_SESSION['logintime']) && isset($_SESSION['userip']) && isset($_SESSION['useragent'])) {
    // Check if the session has expired or if there was a long period of inactivity
    if (time() - $_SESSION['logintime'] > $session_lifetime || time() - $_SESSION['logintime'] > $inactivity_timeout) {
        $loginError = true;
    } else {
        // Validate IP and User-Agent to prevent session hijacking
        if ($_SESSION['userip'] === $_SERVER['REMOTE_ADDR'] && $_SESSION['useragent'] === $_SERVER['HTTP_USER_AGENT']) {
            // Session is valid, user is considered logged in
            $isLoggedIn = true;
            $username = $_SESSION['username'];
            $_SESSION['logintime'] = time(); // Refresh the session timestamp on each request
        } else {
            $loginError = true;
        }
    }
}

// If login error occurs, destroy the session data
if (isset($loginError) && $loginError) {
    session_unset();  // Unset session variables
    session_destroy(); // Destroy the session
    setcookie(session_name(), '', time() - 3600, '/'); // Invalidate the session cookie
}

// Regenerate session ID to avoid session fixation attacks
if ($isLoggedIn) {
    session_regenerate_id(true); // Generate a new session ID and delete the old one
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/base.css">
    <title>Login</title>
</head>
<body>
<section>
<?php if (!$isLoggedIn): ?>
    <h1>LOGIN</h1>

    <form action="" method="POST">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Sign in</button>
    </form>
</section>
</body>
</html>
<?php else: header("Location: /"); ?>

<?php endif; ?>


