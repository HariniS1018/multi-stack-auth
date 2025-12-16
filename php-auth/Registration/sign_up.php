s<?php
    $current_page = "SIGN UP"
?>
<?php
    require_once("includes/header.php");
    require_once("includes/functions.php");
    require_once("includes/config.php");
?>
    <div class="container">
        <div class="content">
            <h2 class="heading">Sign Up</h2>
            <?php
                
                // google recaptcha
                $public_key = RECAPTCHA_SITE_KEY;
                $private_key = RECAPTCHA_SECRET_KEY;
                $url = RECAPTCHA_VERIFY_URL;


                if(isset($_POST['sign-up'])){

                    $response_key = $_POST['g-recaptcha-response'];
                    $response = file_get_contents($url."?secret=".$private_key."&response=".$response_key."&remoteip=".$_SERVER['REMOTE_ADDR']);
                    $response = json_decode(($response));

                    if(!($response->success == true)){
                        $errCaptcha = "wrong captcha";
                    }
                    // print_r($response);
                    $first_name            =  escape($_POST['first_name']);
                    $last_name             =  escape($_POST['last_name']);
                    $user_name             =  escape($_POST['user_name']);
                    $user_email            =  escape($_POST['user_email']);
                    $user_password         =  escape($_POST['user_password']);
                    $user_confirm_password =  escape($_POST['user_confirm_password']);

                    $pattern_fn = "/^[a-zA-Z ]{3,12}$/";
                    $pattern_ln = "/^[a-zA-Z ]{3,12}$/";
                    $pattern_un = "/^[a-zA-Z0-9_]{3,12}$/";
                    
                    if(!preg_match($pattern_fn,$first_name)){
                        $errfn = "Your first name should have atleast 3 characters, alphabets and space are allowed";
                    }
                    if(!preg_match($pattern_ln,$last_name)){
                        $errln = "Your last name should have atleast 3 characters, alphabets and space are allowed";
                    }
                    if(!preg_match($pattern_un,$user_name)){
                        $errun = "Your user name should have atleast 3 characters, alphabets,numbers and under_score are allowed";
                    }else{
                        $query = "select *from users where user_name='$user_name'";
                        $query_conn = mysqli_query($conn,$query);
                        if(!$query_conn){
                            die ("query failed".mysqli_error($conn));
                        }
                        else{
                            $count = mysqli_num_rows($query_conn);
                            if($count == 1){
                                $errun = "user name already taken... please pick new one...";
                            }
                        }
                    }
                    if(!filter_var($user_email,FILTER_VALIDATE_EMAIL)){
                        $errue = "Invalid email format";
                    }
                    else{
                        $query = "select *from users where email_id='$user_email'";
                        $query_conn = mysqli_query($conn,$query);
                        if(!$query_conn){
                            die ("query failed".mysqli_error($conn));
                        }
                        else{
                            $count = mysqli_num_rows($query_conn);
                            if($count == 1){
                                $errue = "email id already exist... please pick new one...";
                            }
                        }
                    }

                    if($user_password !== $user_confirm_password){
                        $errpass = "Passwords do not match";
                    } else {
                        $pattern_up = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{4,56}$/";
                        if(!preg_match($pattern_up,$user_password)){
                            $errpass = "Password must be 4–56 chars, with at least 1 uppercase, 1 lowercase, and 1 number";
                        }
                    }

                    if(!isset($errfn) && !isset($errln) && !isset($errun) && !isset($errue) && !isset($errpass) &&!isset($errCaptcha)){

                        //recipient
                        $mail->addAddress($_POST['user_email']);
                        $email = base64_encode(urlencode($_POST['user_email']));
                        $expire_date = date("Y-m-d H:i:s", time() + 60 * 20);
                        $expire_date = base64_encode(urlencode($expire_date ));
                        
                        $token = getToken(32);
                        $mail->isHTML(true); //set to false for plain text email
                        $mail->Subject = "verifying ur email";
                        $mail->Body = "<h2>Thank you for signing up...</h2>
                                        <a href='http://localhost:8080/Authorization/Registration/activation.php?eid={$email}&token={$token}&exd={$expire_date}'>click here to verify</a>
                                        <p> This link is active only for 20mins</p>";
                        if($mail->send()){
                            $hash = password_hash($user_password,PASSWORD_BCRYPT,['cost'=> 10]);
                            $query = "INSERT INTO users(first_name,last_name,user_name,email_id,password,validation_key) VALUES('$first_name','$last_name','$user_name','$user_email','$hash','$token')";
                            $query_conn = mysqli_query($conn,$query);
                            if(!$query_conn){
                                die("$query failed".mysqli_error($conn));
                            }
                            else{
                                echo "<div class='notification'>Sign up successful. Check your email for activation link</div>";
                                unset($first_name);
                                unset($last_name);
                                unset($user_name);
                                unset($user_email);
                                unset($user_password);
                                unset($user_confirm_password);
                            }
                        }

                        else{
                            echo "<div class='notification'>Sign up unsuccessful... something went wrong... </div>";
                        }
                    }
                }
            ?>
            <!-- <div class='notification'>Sign up successful. Check your email for activation link</div> -->
            <form action="sign_up.php" method="POST">
                <div class="input-box">
                    <input type="text" class="input-control" placeholder="First name" name="first_name" value="<?php echo isset($first_name)?$first_name:''; ?>" autocomplete="off" required>
                    <?php echo isset($errfn)?"<span class='error'>{$errfn}</span>":"";?>
                </div>
                <div class="input-box">
                    <input type="text" class="input-control" placeholder="Last name" name="last_name" value="<?php echo isset($last_name)?$last_name:''; ?>" autocomplete="off" required>
                    <?php echo isset($errln)?"<span class='error'>{$errln}</span>":"";?>
                </div>
                <div class="input-box">
                    <input type="text" class="input-control" placeholder="Username" name="user_name" value="<?php echo isset($user_name)?$user_name:''; ?>" autocomplete="off" required>
                    <?php echo isset($errun)?"<span class='error'>{$errun}</span>":"";?>
                </div>
                <div class="input-box">
                    <input type="email" class="input-control" placeholder="Email address" name="user_email" value="<?php echo isset($user_email)?$user_email:''; ?>" autocomplete="off" required>
                    <?php echo isset($errue)?"<span class='error'>{$errue}</span>":"";?>
                </div>
                <div class="input-box">
                    <input type="password" class="input-control" placeholder="Enter password" name="user_password" autocomplete="off" required>
                    <?php echo isset($errpass)?"<span class='error'>{$errpass}</span>":"";?>
                </div>
                <div class="input-box">
                    <input type="password" class="input-control" placeholder="Confirm password" name="user_confirm_password" autocomplete="off" required>
                    <?php echo isset($errpass)?"<span class='error'>{$errpass}</span>":"";?>
                </div>
                <div class="g-recaptcha" data-sitekey="<?php echo $public_key; ?>"></div>
                <?php echo isset($errCaptcha)?"<span class='error'>{$errCaptcha}</span>":"";?>
                <div class="input-box">
                    <input type="submit" class="input-submit" value="SIGN UP" name="sign-up">
                </div>
                <div class="sign-up-cta"><span>Already have an account?</span> <a href="login.php">Login here</a></div>
            </form>

        </div>
    </div>
<?php
    require_once("includes/footer.php");
?>
