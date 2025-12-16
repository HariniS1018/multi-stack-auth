<?php
ob_start();

// If form is submitted, set cookies
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $firstname = $_POST['firstname'] ?? '';

    // Set cookies for 1 day: 60 * 60 *24 = 86400 seconds
    setcookie('username', $username, time() + 86400);
    setcookie('firstname', $firstname, time() + 86400);

    echo "Cookies have been set!<br>";  // remove this for production
}

// Display cookies to check, remove the below lines in production.
if (isset($_COOKIE['username'])) {
    echo "Username cookie: " . htmlspecialchars($_COOKIE['username']) . "<br>";
}
if (isset($_COOKIE['firstname'])) {
    echo "Firstname cookie: " . htmlspecialchars($_COOKIE['firstname']) . "<br>";
}

?>