<?php session_start(); ?>
<?php $current_page = "LOGIN" ?>
<?php 
    require_once("includes/header.php"); 
    require_once("includes/config.php");
?>

    <div class="container">
        <div class="content">
            <h2 class="heading">Login</h2>
            <?php
                // google recaptcha
                $public_key = RECAPTCHA_SITE_KEY;
                $private_key = RECAPTCHA_SECRET_KEY;
                $url = RECAPTCHA_VERIFY_URL;

                if(isset($_POST['resend'])){
                    if(!isset($_COOKIE['_utt_'])){
                        $user_name             =  escape($_POST['user_name']);
                        $user_email            =  escape($_POST['user_email']);

                        //recipient
                        $mail->addAddress($_POST['user_email']);
                        $email = base64_encode(urlencode($_POST['user_email']));
                        $expire_date = date("Y-m-d H:i:s", time() + 60 * 20);
                        $expire_date = base64_encode(urlencode($expire_date ));
                        $token = getToken(32);
                        $mail->isHTML(true); //set to false for plain text email
                        
                        $query = "update users set validation_key = '$token' where user_name = '$user_name' and email_id='$user_email' and is_active=0";
                        $query_conn = mysqli_query($conn,$query);
                        if(!$query_conn){
                            die("$query failed".mysqli_error($conn));
                        }
                        else{
                            $mail->Subject = "verifying ur email";
                            $mail->Body = "<h2>Follow the link to verify...</h2>
                                            <a href='http://localhost:8080/Authorization/Registration/activation.php?eid={$email}&token={$token}&&exd={$expire_date}'>click here to verify</a>
                                            <p> This link is active only for 20mins</p>";

                            if($mail->send()){
                                setcookie('_utt_',getToken(16),time() + 60*20, '','','',true);
                                echo "<div class='notification'>check your email for activation link</div>";
                            }
                        }
                    }
                    else{
                        echo "<div class='notification'>you must wait atleast 20 minutes for another activation link</div>";
                    }
                }
                $isAuthenticated = false;
                if(isset($_POST['login'])){

                    $response_key = $_POST['g-recaptcha-response'];
                    $response = file_get_contents($url . "?secret=" . $private_key . "&response=" . $response_key . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
                    $response = json_decode($response);

                    if (!$response || $response->success !== true) {
                        $errCaptcha = "Wrong captcha";
                    }
                    
                    $user_name             =  escape($_POST['user_name']);
                    $user_email            =  escape($_POST['user_email']);
                    $user_password         =  escape($_POST['user_password']);

                    $query = "select *from users where user_name='$user_name' and email_id = '$user_email'";
                    $query_conn = mysqli_query($conn,$query);
                    if(!$query_conn){
                        die ("query failed".mysqli_error($conn));
                    }
                    else{
                        $result = mysqli_fetch_assoc($query_conn);
                        if($result && password_verify($user_password, $result['password'])){
                            if($result['is_active'] == 1){
                                if(!isset($errCaptcha)){
                                    $isAuthenticated = true;
                                    echo "<div class='notification'>Logged In Successfully</div>";
                                    $_SESSION['login'] = 'success';
                                    header("Refresh:2;url=index.php");
                                }
                            }
                            else{
                                if(!isset($errCaptcha)){
                                    echo "<div class='notification'>You are not verified user
                                        <form method='POST'>
                                        <input type='hidden' name='user_name' value="<?php echo htmlspecialchars($user_name); ?>">
                                        <input type='hidden' name='user_email' value="<?php echo htmlspecialchars($user_email); ?>">
                                        <input type='submit' class='resend' name='resend' value='click here for activation link'>
                                        </form></div>";
                                }
                            }
                        }
                        else{
                            echo "<div class='notification'>Invalid user_name or email_id or password</div>";
                        }
                    }

                    if($isAuthenticated){

                        if(!empty($_POST['remember_me'])){
                            $selector = getToken(32);
                            $encoded_selector = base64_encode(($selector));
                            setcookie('_ucv_', $encoded_selector, time() + 60*60*24*2,'','','',true);

                            date_default_timezone_set(APP_TIMEZONE);
                            $expire = date("Y-m-d H:i:s", time() + 60*60*24*2);
                        
                            $query2 = "insert into remember_me(user_name, selector, expire_date, is_expired) values('$user_name','$selector','$expire',0)";
                            $query2_conn = mysqli_query($conn,$query2);
                            if(!$query2_conn){
                                die ("query failed".mysqli_error($conn));
                            }

                        }
                    }
                    if(isAlreadyLoggedIN()){
                        echo "LoggedIn";
                    }
                    else{
                        echo "not LoggedIn";
                    }
                }
            ?>

            <!-- <div class='notification'>Logged In Successfully</div> -->
            <form action="login.php" method="POST">
                <div class="input-box">
                    <input type="text" class="input-control" placeholder="Username" name="user_name" required>
                </div>
                <div class="input-box">
                    <input type="email" class="input-control" placeholder="Email address" name="user_email" required>
                </div>
                <div class="input-box">
                    <input type="password" class="input-control" placeholder="Enter password" name="user_password" required>
                </div>
                <div class="input-box rm-box">
                    <div>
                        <input type="checkbox" id="remember-me" class="remember-me" name="remember_me">
                        <label for="remember-me">Remember me</label>
                    </div>
                    <a href="forgot_password.php" class="forgot-password">Forgot password?</a>
                </div>
                <div class="g-recaptcha" data-sitekey="<?php echo $public_key; ?>"></div>
                <?php echo isset($errCaptcha)?"<span class='error'>{$errCaptcha}</span>":"";?>
                <div class="input-box">
                    <input type="submit" class="input-submit" value="LOGIN" name="login">
                </div>
                <div class="login-cta"><span>Don't have an account?</span> <a href="sign_up.php">Sign up here</a></div>
            </form>

        </div>
    </div>
<?php
    require_once("includes/footer.php");
?>
