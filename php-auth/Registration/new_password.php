<?php ob_start(); ?>
<?php require_once("includes/functions.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Password</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="content">
            <h2 class="heading">New Password</h2>
            <?php
                $check = false;
                if(isset($_GET['eid']) && isset($_GET['token']) && isset($_GET['exd'])){
                    $user_email      =  urldecode(base64_decode($_GET['eid']));
                    $validation_key  =  urldecode(base64_decode($_GET['token']));
                    $expire_date     =  urldecode(base64_decode($_GET['exd']));

                    date_default_timezone_set("asia/kolkata");
                    $current_date = date("Y-m-d H:i:s");

                    if($expire_date <= $current_date){
                        echo "<div class='notification'>Link expired</div>";
                    }
                    else{
                        $check =true;
                        if(isset($_POST['submit'])){
                            $user_confirm_password = escape($_POST['confirm_new_password']);
                            $new_password = escape($_POST['new_password']);

                            if($new_password == $user_confirm_password){
                                $pattern_up = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{4,56}$/";
                                if(!preg_match($pattern_up,$new_password)){
                                    $errpass = "Your password should have atleast 4 characters, atleast 1 uppercase, 1 lowercase and 1 number exist";
                                }
                            }
                            else{
                                $errpass = "password mismatched";
                            }
                            if(!isset($errpass)){
                                $query = "select *from users where email_id = '$user_email' and validation_key = '$validation_key' and is_active=1";
                                $query_conn = mysqli_query($conn,$query);
                                if(!$query_conn){
                                    die ("query failed".mysqli_error($conn));
                                }
                                else{
                                    $count = mysqli_num_rows($query_conn);
                                    if($count >= 1){
                                        $hash = password_hash($new_password,PASSWORD_BCRYPT,['cost'=> 10]);
                                        $query1 = "update users set password = '$hash' where validation_key='$validation_key' and email_id='$user_email' and is_active=1";
                                        $query1_conn = mysqli_query($conn,$query1);
                                        if(!$query1_conn){
                                            die("$query1 failed".mysqli_error($conn));
                                        }
                                        else{
                                            $query2 = "update users set validation_key= NULL where email_id='$user_email' and is_active=1";
                                            $query2_conn = mysqli_query($conn,$query2);
                                            if(!$query2_conn){
                                                die("$query2 failed".mysqli_error($conn));
                                            }
                                            echo "<div class='notification'>Password created successfully...</div>";
                                            header("Refresh:3; url=login.php");
                                        }
                                    }
                                    else{
                                        echo "<div class='notification'>Invalid Link</div>";
                                    }
                                }
                            }
                        }
                    }
                }
                else{
                    echo "<div class='notification'>Something went wrong</div>";
                }

                if(isset($errpass)){
                    echo "<div class='notification'>{$errpass}</div>";
                }
            ?>
            <!-- <div class='notification'>Password updated successfully. <a href='login.php'>login now</a></div> -->
            <form action="" method="POST">
                <div class="input-box">
                    <input type="password" class="input-control" placeholder="New password" name="new_password" required <?php echo !$check ? "disabled" : ""; ?>>
                </div>
                <div class="input-box">
                    <input type="password" class="input-control" placeholder="Confirm new password" name="confirm_new_password" required <?php echo !$check ? "disabled" : ""; ?>>
                </div>
                <div class="input-box">
                    <input type="submit" class="input-submit" value="SUBMIT" name="submit" >
                </div>
            </form>

        </div> 
    </div>
</body>
</html>