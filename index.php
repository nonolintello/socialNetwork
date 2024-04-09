<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Media Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-image: url('background_image.jpg');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body>
    <div class="container" style="width: 300px; padding: 20px; background-color: rgba(255, 255, 255, 0.8); border-radius: 10px; text-align: center; margin: auto; margin-top: 10%; position: relative;">
        <!-- login ui -->
        <div id="login-form">
            <h2>Login</h2>
            <form action="login_process.php" method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="button" value="Login" onclick="login()">
            </form>
            <p>Don't have an account? <a href="register.php" class="register-link">Register</a></p> <!-- skip to register -->
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
