<?php

class ImgFileUploader
{
    private $savePath = "images/postImages/";
    private $dbConn;
    public $hasAdequateFile = false;
    public $errorText = "";

    function __construct(&$conn)
    {
        $this->dbConn = $conn;
        $this->hasAdequateFile = $this->isBufferFileAdequate();
    }

    function isBufferFileAdequate()
    {
        if (isset($_FILES['imageFile']) && $_FILES['imageFile']['size'] > 0) {
            if ($_FILES['imageFile']['size'] > 5242880) {
                $this->errorText = "Fichier trop grand! Respectez la limite de 5 Mo.";
                return false;
            }

            $fileType = $_FILES['imageFile']['type'];
            if ($fileType == "image/jpeg" || $fileType == "image/png") {
                return true;
            }

            $this->errorText = "Type de fichier non accepté! JPG et PNG uniquement.";
            return false;
        }

        $this->errorText = "Aucun fichier ou taille de fichier à zéro.";
        return false;
    }

    function saveFileAsNew($postID)
    {
        if ($this->hasAdequateFile) {
            $file = $_FILES['imageFile']['name'];
            $path = pathinfo($file);
            $ext = isset($path['extension']) ? $path['extension'] : '';
            $tempName = $_FILES['imageFile']['tmp_name'];
            $newFilename = $this->dbConn->loginStatus->userID . "_" . date("mdyHis");
            $pathFilenameExt = $this->savePath . $newFilename . "." . $ext;

            if ($ext === '' || !in_array(strtolower($ext), ['jpg', 'jpeg', 'png'])) {
                $this->errorText = "Extension de fichier non valide.";
                return;
            }

            if (file_exists($pathFilenameExt)) {
                $this->errorText = "Erreur, le fichier existe déjà.";
            } else {
                $this->updateImageInPost($postID, $pathFilenameExt);
                $this->generateThumbnail($newFilename, $ext);
                move_uploaded_file($tempName, $pathFilenameExt);
                $this->errorText = "Fichier téléchargé avec succès.";
            }

            echo $this->errorText;
        } else {
            $this->updateImageInPost($postID, "");
        }
    }

    function overrideOldFile($postID)
    {
        $this->deleteFile($postID);
        $this->saveFileAsNew($postID);
    }

    function deleteFile($postID)
    {
        $query = "SELECT `url_image` FROM `post` WHERE `id` = :postID";
        $stmt = $this->dbConn->db->prepare($query);
        $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (isset($row['url_image']) && file_exists($row['url_image'])) {
                unlink($row['url_image']);
            }

            if (isset($row['url_image'])) {
                $pathFragments = pathinfo($row['url_image']);
                if (isset($pathFragments['dirname']) && isset($pathFragments['filename'])) {
                    $thumbPath = $pathFragments['dirname'] . "/" . $pathFragments['filename'] . "_thumb.png";
                    if (file_exists($thumbPath)) {
                        unlink($thumbPath);
                    }
                }
            }
        }
    }

    function updateImageInPost($postID, $pathFilenameExt)
    {
        $query = "UPDATE `post` SET `url_image` = :pathFilenameExt WHERE `id` = :postID";
        $stmt = $this->dbConn->db->prepare($query);
        $stmt->bindParam(':pathFilenameExt', $pathFilenameExt, PDO::PARAM_STR);
        $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
        $stmt->execute();
    }

    function generateThumbnail($imageName, $extension)
    {
        if (isset($_FILES['imageFile']['tmp_name'])) {
            $fileName = $_FILES['imageFile']['tmp_name'];
            if (file_exists($fileName)) {
                list($width, $height) = getimagesize($fileName);
                $goalWidth = 200;
                $ratio = $goalWidth / $width;
                $newHeight = $height * $ratio;

                $src = imagecreatefromstring(file_get_contents($fileName));
                $dst = imagecreatetruecolor($goalWidth, $newHeight);
                imagecopyresampled($dst, $src, 0, 0, 0, 0, $goalWidth, $newHeight, $width, $height);

                $thumbPath = $this->savePath . $imageName . "_thumb.png";
                imagepng($dst, $thumbPath);

                imagedestroy($src);
                imagedestroy($dst);
            }
        } else {
            $this->errorText = "Fichier temporaire introuvable.";
        }
    }
}

?>
