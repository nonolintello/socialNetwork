<?php
include("./ini.php");

if (isset($_GET["postID"])) {
    $postID = (int)$_GET["postID"];
?>
    <form enctype="multipart/form-data" action="processPost.php" method="POST">
        <input type="hidden" name="redirect_url" value="<?php echo $_SERVER['HTTP_REFERER']; ?>">
        <h3>Répondre au post</h3>
        <input type="hidden" name="action" value="reply">
        <input type="hidden" name="parentID" value="<?php echo htmlspecialchars($postID); ?>">

        <div class="mb-3">
            <label for="title" class="form-label">Titre du post réponse</label>
            <input type="text" name="title" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Message :</label>
            <textarea name="content" class="form-control" rows="4" required>Votre réponse commence ici...</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Soumettre la réponse</button>
    </form>
<?php
} else {
    echo "Erreur : Aucun post ID fourni.";
}
?>