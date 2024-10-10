<?php
// Start or resume the session
session_name(SESSIONCOOKIE_NAME);
session_start();


// Check if user is logged in by verifying the session variables
function isLoggedIn() {
    return isset($_SESSION['username']) && 
           isset($_SESSION['logintime']) && 
           isset($_SESSION['userip']) && 
           isset($_SESSION['useragent']) &&
           $_SESSION['userip'] === $_SERVER['REMOTE_ADDR'] &&
           $_SESSION['useragent'] === $_SERVER['HTTP_USER_AGENT'];
}
?>
