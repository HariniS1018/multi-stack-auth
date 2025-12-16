<form action="register.php" method="post">
    <input type="text" placeholder="Enter your name" name="name">
    <input type="email" placeholder="Enter your email" name="email">
    <input type="submit" value="submit" name="submit">
</form>

<?php
if (isset($_POST['submit'])) {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    echo htmlspecialchars($name);   // to prevent XSS attacks
    echo htmlspecialchars($email);
}
?>

