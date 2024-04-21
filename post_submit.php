<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'db_connect.php'; // Assume db_connect.php sets up $mysqli appropriately

class PostSubmitHandler {
    private $db;
    private $userId;

    public function __construct($db, $userId) {
        $this->db = $db;
        $this->userId = $userId;
    }

    public function handlePostSubmission() {
        $postText = $_POST['post_text'] ?? '';
        $imagePath = $this->handleImageUpload();

        if ($imagePath === false) {
            // Handle upload error
            $this->redirectWithError("Failed to upload image.");
        }

        $this->storePost($postText, $imagePath);
    }

    private function handleImageUpload() {
        if (empty($_FILES['post_image']['name'])) {
            return null; // No file uploaded
        }

        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["post_image"]["name"]);
        if ($_FILES['post_image']['error'] == UPLOAD_ERR_OK) {
            if (move_uploaded_file($_FILES["post_image"]["tmp_name"], $targetFile)) {
                return $targetFile;
            } else {
                return false; // Upload failed
            }
        }
        return false; // Error in file upload
    }

    private function storePost($text, $imagePath) {
        $stmt = $this->db->prepare("INSERT INTO post (texte, url_image, id_owner) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $text, $imagePath, $this->userId);
        if (!$stmt->execute()) {
            $this->redirectWithError("Failed to save post: " . $stmt->error);
        }
        header('Location: homepage.php');
        exit;
    }

    private function redirectWithError($error) {
        header("Location: homepage.php?error=" . urlencode($error));
        exit;
    }
}

$handler = new PostSubmitHandler($mysqli, $_SESSION['user_id']);
$handler->handlePostSubmission();
?>
