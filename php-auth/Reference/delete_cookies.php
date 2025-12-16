<?php
ob_start();

// delete the cookies by setting expiration time in the past.
if (isset($_COOKIE['username'])) {
    setcookie('username','',time() - 86400);
}
if (isset($_COOKIE['firstname'])) {
    setcookie('firstname','',time() - 86400);
}

?>