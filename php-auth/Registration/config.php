<?php
    define("DB_HOST", "db_host_name");
    define("DB_USER", "db_user_name");
    define("DB_PASS", "db_password");
    define("DB_NAME", "db_name");
    
    define("APP_TIMEZONE", "Asia/Kolkata");
    define("HASHING_TEST_PASSWORD", "password_that_need_to_be_hashed");
    
    // reCAPTCHA constants
    define("RECAPTCHA_SITE_KEY", "your_site_key_here");
    define("RECAPTCHA_SECRET_KEY", "your_secret_key_here");
    define("RECAPTCHA_VERIFY_URL", "https://www.google.com/recaptcha/api/siteverify");
    
    // SMTP + Email constants
    define("SMTP_HOST", "smtp.gmail.com");
    define("SMTP_PORT", 587);
    define("SMTP_ENCRYPTION", "tls");
    define("EMAIL_USERNAME", "admin_mail_id");
    define("EMAIL_PASSWORD", "admin_mail_app_password");
    define("FROM_EMAIL", "admin_mail_id");
    define("FROM_NAME", "Admin Name");
    define("TO_EMAIL", "reply_to_email_id");
    define("TO_NAME", "Reply To Name");
?>