<?php
    require_once("includes/db.php");
    require_once("includes/config.php");
    
    if(isset($_GET['eid']) && isset($_GET['token']) && isset($_GET['exd'])){
        $validation_key = $_GET['token'];
        $email = urldecode(base64_decode($_GET['eid']));
        $expiry =  urldecode(base64_decode($_GET['exd']));

        date_default_timezone_set(APP_TIMEZONE);
        $current_time = date("Y-m-d H:i:s");

        if($expiry <= $current_time){
            echo "Link expired";
        }
        else{
            $query1 = "select *from users where email_id='$email' and validation_key='$validation_key' and is_active=1";
            $query1_con = mysqli_query($conn,$query1);
            if(!$query1_con){
                die("query failed".mysqli_error($conn));
            }
            $count = mysqli_num_rows($query1_con);
            if($count == 1){
                echo "Email already verified";
            }
            else{
                $query = "update users set is_active=1 where email_id = '$email' and validation_key = '$validation_key'";
                $query_con = mysqli_query($conn,$query);
                if(!$query_con){
                    die("query failed".mysqli_error($conn));
                }
                else{
                    echo "Email has successfully verified";
                }
            }
        }
    }
?>