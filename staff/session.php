<?php
// Initialize session with secure settings
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', 1); // Enable if using HTTPS
    ini_set('session.use_strict_mode', 1);
    ini_set('session.cookie_samesite', 'Strict');
    session_start();
}

// Validate session
if (!isset($_SESSION['user_id'], $_SESSION['role'], $_SESSION['last_activity']) || $_SESSION['role'] !== 'staff') {
    // Store requested URL for redirect after login
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    session_regenerate_id(true);
    session_destroy();
    header("Location: ../index.php");
    exit();
}

// Check for inactivity (30 minutes)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
    session_unset();
    session_destroy();
    header("Location: ../index.php?timeout=1");
    exit();
}

// Update last activity time
$_SESSION['last_activity'] = time();

// CSRF token generation (if needed)
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>