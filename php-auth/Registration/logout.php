<?php
    require_once("includes/functions.php");
    require_once("includes/db.php");
    ob_start();
    session_start();
    
    if(isset($_COOKIE['_ucv_'])){
        $selector = escape(base64_decode($_COOKIE['_ucv_']));
        $query = "update remember_me set is_expired='-1' where selector='$selector' and is_expired = 0";
        $query_conn = mysqli_query($conn,$query);
        if(!$query_conn){
            die ("query failed".mysqli_error($conn));
        }
        setcookie('_ucv_', '', time() - 3600, '/');
    }
    if(isset($_SESSION['login'])){
        session_destroy();
        unset($_SESSION['login']);
        unset($_SESSION['name']);
        session_destroy();
    }

    header("Location:login.php");
?>