<?php
include("./ini.php");
include("./classes/imageUpload.php");

if (isset($_POST["title"]) && $_FILES["imageFile"]["size"] > 0) {
    $uploader = new ImgFileUploader($dbConn);

    if ($uploader->hasAdequateFile) {
        $query = "INSERT INTO post (titre) VALUES (:title)";
        $stmt = $dbConn->db->prepare($query);
        $stmt->bindParam(':title', $dbConn->sanitize($_POST["title"]), PDO::PARAM_STR);
        $stmt->execute();
        $uploader->SaveFileAsNew($dbConn->db->lastInsertId());
    }
}

include(__ROOT__ . "/codePart/header.php");
?>

<form enctype="multipart/form-data" action="#" method="POST">
    <div class="formbutton">Test d'Upload d'une image</div>
    <div>
        <input type="hidden" name="action" value="new">
        <label for="title">Titre :</label>
        <input autofocus type="text" name="title">
    </div>
    <div>
        <input type="hidden" name="MAX_FILE_SIZE" value="5242880">
        <label for="imageFile">Fichier d'image :</label>
        <input name="imageFile" type="file">
    </div>
    <div>
        <p>(Le fichier d'image est facultatif)</p>
    </div>
    <div class="formbutton">
        <button type="submit">Ajouter ce post à mon blog</button>
    </div>
</form>

<?php
include(__ROOT__ . "/codePart/footer.php");
$dbConn->disconnect();
?>
