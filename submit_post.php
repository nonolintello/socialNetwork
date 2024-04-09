<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // get text and image
    $text = $_POST['text'];
    $image = $_FILES['image'];

    if ($image && $image['error'] === UPLOAD_ERR_OK) {
        // move image to listforimage
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image['name']);
        move_uploaded_file($image['tmp_name'], $target_file);

        // image and text saved in db
        // time can be added
        $servername = "localhost";
        $username = "your_username";
        $password = "your_password";
        $dbname = "your_database";

        // connect
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO posts (text, image) VALUES ('$text', '$target_file')";
        if ($conn->query($sql) === TRUE) {

            echo "Post submitted successfully.";
        } else {

            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // close
        $conn->close();
    } else {
        // no image
        echo "Error uploading image.";
    }
} else {
    // non-post request
    echo "Method not allowed";
}
?>

