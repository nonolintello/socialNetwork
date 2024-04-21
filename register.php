<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="./Styles/login&register_styles.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="form-container">
        <form method="post">
            <h2>Register</h2>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="submit" name="register" value="Register">
            <div class="link-container">
                <a href="login.php">Return to Login</a>
            </div>
        </form>
    </div>

    <?php
    // Database connection - This should be replaced with your actual database connection code
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'projet';
    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

    session_start();

    // Handling user registration
    if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = $_POST['password']; // Remember to use password hashing in production
        $email = $_POST['email']; // Assuming email is also collected in registration

        // Check if user exists
        $stmt = $mysqli->prepare('SELECT * FROM user WHERE nom = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<div class="error">User already exists</div>';
        } else {
            // Insert new user
            $insert_stmt = $mysqli->prepare('INSERT INTO user (nom, mdp, email) VALUES (?, ?, ?)');
            $insert_stmt->bind_param('sss', $username, $password, $email);
            $insert_stmt->execute();
            echo '<div class="success">Registration successful</div>';
        }
    }
    ?>
</body>
</html>
