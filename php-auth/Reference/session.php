<?php
    ob_start();
    session_start();
    
    if (isset($_SESSION['name'])) {
        echo "Session set for: " . htmlspecialchars($_SESSION['name']);
    }
?>
    