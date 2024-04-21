<?php
session_start(); // Start session at the very top to ensure it works correctly

// Database connection setup
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'projet';
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Handling user login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password']; // Directly use the entered password without hashing

    $stmt = $mysqli->prepare('SELECT id, mdp FROM user WHERE nom = ? AND mdp = ?');
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id']; // Store user id in session
        header('Location: homepage.php'); // Redirect to homepage
        exit();
    } else {
        $error = 'Username or password is incorrect';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta viewport="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="./Styles/login&register_styles.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="form-container">
        <form method="post">
            <h2>Login</h2>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="login" value="Login">
            <div class="link-container">
                <a href="register.php">Register Account</a>
            </div>
            <?php if (!empty($error)): ?>
                <div class="error"><?= $error ?></div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>

