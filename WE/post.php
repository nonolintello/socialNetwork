<?php
include("./ini.php");
include(__ROOT__ . "/codePart/header.php");


if (isset($_POST["newPost"]) && $_POST["newPost"] == 1) {
    ?>
    <form enctype="multipart/form-data" action="./processPost.php" method="POST">
        <div class="formbutton">Création d'un post</div>
        <div>
            <input type="hidden" name="action" value="new">
            <label for="title">Intitulé du post :</label>
            <input autofocus type="text" name="title" required>
        </div>
        <div>
            <label for="content">Message du post :</label>
            <textarea name="content" required> Votre post commence ici...</textarea>
        </div>
        <div>
        <input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
        <label for="imageFile">Image (facultative) :</label>
        <input name="imageFile" type="file" />
    </div>
        <div class="formbutton">
            <button type="submit">Ajouter ce post à mon blog</button>
        </div>
    </form>
    <?php
}
elseif (isset($_GET["postID"])) {
    $postID = (int)$_GET["postID"];
    
    $query = 'SELECT * FROM `post` WHERE `id` = :postID';
    $stmt = $dbConn->db->prepare($query);
    $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        ?>
        <form enctype="multipart/form-data" action="./processPost.php" method="POST">
            <div class="formbutton">Modifier votre post</div>
            <div>
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="postID" value="<?php echo $data['id']; ?>">
                <label for="title">Titre :</label>
                <input autofocus type="text" name="title" value="<?php echo htmlspecialchars($data['texte']); ?>" required>
            </div>
            <div>
                <label for="content">Message :</label>
                <textarea name="content" required><?php echo htmlspecialchars($data['texte']); ?></textarea>
            </div>
            <div>
            <input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
            <label for="imageFile">Image (facultative) :</label>
            <input name="imageFile" type="file" />
            </div>
            <div class="formbutton">
                <button type="submit">Modifier le post</button>
            </div>
        </form>
        

        <form action="./processPost.php" method="POST">  <!-- onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ?')"> -->
            <div class="formbutton">Cliquez ici pour supprimer le post</div>
            <div>
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="postID" value="<?php echo $data['id']; ?>">
            </div>
            <div class="formbutton">
                <button type="submit">Supprimer le post</button>
            </div>
        </form>
        <?php
    } else {
        echo "<h1>Erreur! Aucune correspondance pour cet ID de post.</h1>";
    }
}

include(__ROOT__ . "/codePart/footer.php");
?>
