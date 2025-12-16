<?php
    require_once("includes/config.php");

    $pass = HASHING_TEST_PASSWORD;
    $hash = password_hash($pass,PASSWORD_BCRYPT,['cost'=>10]);
    
    if(password_verify($pass,$hash)){
        echo "password matched";
    }
    else{
        echo "password mismatched";
    }

?>