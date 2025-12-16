<?php 
require_once("db.php");
require_once(__DIR__ . "/../config.php");

function escape($string){
    global $conn;
    return mysqli_real_escape_string($conn,$string);
}

function getToken($len){
    $rand_Str = base64_encode(md5(uniqid(mt_rand(),true)));
    $modified_Str = str_replace(array('+','='),array('',''),$rand_Str);
    $token = substr($modified_Str,0,$len);
    return $token;
}

function selectUSerByToken($token){
    global $conn;
    $query = "select user_name from remember_me where selector='$token' and is_expired = 0";
    $query_conn = mysqli_query($conn,$query);
    if(!$query_conn){
        die ("query failed".mysqli_error($conn));
    }
    
    $result = mysqli_fetch_assoc($query_conn);
    if(!$result){
        return null;
    }
    $user_name = $result['user_name'];
    $query2 = "select * from users where user_name='$user_name'";
    $query2_conn = mysqli_query($conn,$query2);
    if(!$query2_conn){
        die ("query failed".mysqli_error($conn));
    }
    
    $result2 = mysqli_fetch_assoc($query2_conn);
    return $result2['first_name']." ".$result2['last_name'];
    
}

function isAlreadyLoggedIN(){
    global $conn;
    date_default_timezone_set(APP_TIMEZONE);
    $current_date = date("Y-m-d H:i:s");
    if(isset($_COOKIE['_ucv_'])){
        $selector = escape(base64_decode($_COOKIE['_ucv_']));

        $query = "select *from remember_me where selector='$selector' and is_expired = 0";
        $query_conn = mysqli_query($conn,$query);
        if(!$query_conn){
            die ("query failed".mysqli_error($conn));
        }
        $result = mysqli_fetch_assoc($query_conn);
        if(!$result){
            return false;
        }
        if(mysqli_num_rows($query_conn) == 1){
            $expire_date = $result['expire_date'];
            if($expire_date >= $current_date){
                $name = selectUSerByToken($selector);
                $_SESSION['name'] = $name;
                return true;
            }
        }
    }
}
?>