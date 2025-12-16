<?php
    $current_page = "PASSWORD RECOVERY"
?>
<?php
    require_once("includes/header.php");
?>
    <div class="container">
        <div class="content">
            <h2 class="heading">Password Recovery</h2>

            <?php
                if(isset($_POST['password_recovery'])){
                    $user_name             =  escape($_POST['user_name']);
                    $user_email            =  escape($_POST['user_email']);

                    $query = "select *from users where user_name='$user_name' and email_id = '$user_email' and is_active=1";
                    $query_conn = mysqli_query($conn,$query);
                    if(!$query_conn){
                        die ("query failed".mysqli_error($conn));
                    }
                    $count = mysqli_num_rows($query_conn);
                    if($count >= 1){
                        if(!isset($_COOKIE['_unp_'])){
                            $user_name             =  escape($_POST['user_name']);
                            $user_email            =  escape($_POST['user_email']);
    
                            //recipient
                            $mail->addAddress($_POST['user_email']);
                            $email = base64_encode(urlencode($_POST['user_email']));
                            $expire_date = date("Y-m-d H:i:s", time() + 60 * 20);
                            $expire_date = base64_encode(urlencode($expire_date ));
                            $token = getToken(32);
                            $encoded_token = base64_encode(urlencode($token ));
                            $mail->isHTML(true); //set to false for plain text email
                            
                            $query = "update users set validation_key = '$token' where user_name = '$user_name' and email_id = '$user_email' and is_active = 1";
                            $query_conn = mysqli_query($conn,$query);
                            if(!$query_conn){
                                die("$query failed".mysqli_error($conn));
                            }
                            else{
                                $mail->Subject = "Password reset request";
                                $mail->Body = "<h2>Follow the link to reset password...</h2>
                                                <a href='http://localhost:8080/Authorization/Registration/new_password.php?eid={$email}&token={$encoded_token}&exd={$expire_date}'>click here to create new password</a>
                                                <p> This link is active only for 20mins</p>";
    
                                if($mail->send()){
                                    setcookie('_unp_',getToken(16),time() + 60*20, '','','',true);
                                    echo "<div class='notification'>check your email for password reset link</div>";
                                }
                            }
                        }
                        else{
                            echo "<div class='notification'>you must wait atleast 20 minutes before requesting for another activation link</div>";
                        }
                    }
                    else{
                        echo "<div class='notification'>Sorry, User not found</div>";
                    }
                }
            
            ?>
            <!-- <div class='notification'>You need to wait at lest 20 minutes for another request</div> -->
            <form action="" method="POST">
                <div class="input-box">
                    <input type="text" class="input-control" placeholder="Username" name="user_name" required>
                </div>
                <div class="input-box">
                    <input type="email" class="input-control" placeholder="Email address" name="user_email" required>
                </div>
                <div class="input-box">
                    <input type="submit" class="input-submit" value="RECOVER PASSWORD" name="password_recovery">
                </div>
            </form>
        </div>
    </div>
<?php
    require_once("includes/footer.php");
?>