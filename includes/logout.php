<?php
require("conn.php");
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Clear session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 3600, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Logout</title>
    <meta http-equiv="refresh" content="2;url=../index.php">
</head>
<body>
    <p>Logged out successfully. Redirecting to the homepage...</p>
    <noscript>
        <p>Logged out successfully. Click <a href="../index.php">here</a> if you are not redirected.</p>
    </noscript>
</body>
</html>
