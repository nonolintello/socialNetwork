<!-- register.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Media Dashboard - Register</title>
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
        <!-- register ui -->
        <div id="register-form">
            <h2>Register</h2>
            <form action="register_process.php" method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" value="Register">
            </form>
            <p>Already have an account? <a href="index.php" class="login-link">Back to Login</a></p> 
        </div>
    </div>
</body>
</html>
