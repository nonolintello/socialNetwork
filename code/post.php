<?php
include("./ini.php");
include(__ROOT__ . "/codePart/header.php");

echo '<div class="container mt-4">';

if ((isset($_POST["newPost"]) && $_POST["newPost"] == 1) || isset($_GET["parentID"])) {
    $isReply = isset($_GET["parentID"]);
    $parentID = $isReply ? (int)$_GET["parentID"] : null;
?>
    <form enctype="multipart/form-data" action="./processPost.php" method="POST">
        <input type="hidden" name="redirect_url" value="<?php echo $_SERVER['HTTP_REFERER']; ?>">
        <h2><?php echo $isReply ? 'Répondre à un post' : 'Créer un nouveau post'; ?></h2>
        <div class="mb-3">
            <input type="hidden" name="action" value="new">
            <?php if ($isReply) : ?>
                <input type="hidden" name="parentID" value="<?php echo htmlspecialchars($parentID); ?>">
            <?php endif; ?>
            <label for="title" class="form-label">Titre du post :</label>
            <input type="text" name="title" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Message :</label>
            <textarea name="content" class="form-control" rows="4" required>Votre post commence ici...</textarea>
        </div>
        <div class="mb-3">
            <input type="hidden" name="MAX_FILE_SIZE" value="5242880">
            <label for="postImage" class="form-label">Image (facultative) :</label>
            <input type="file" name="postImage" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary"><?php echo $isReply ? 'Répondre' : 'Créer le post'; ?></button>
    </form>
    <?php
} elseif (isset($_GET["postID"])) {
    $postID = (int)$_GET["postID"];

    $query = 'SELECT * FROM `post` WHERE `id` = :postID';
    $stmt = $dbConn->db->prepare($query);
    $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
        <form enctype="multipart/form-data" action="./processPost.php" method="POST">
            <input type="hidden" name="redirect_url" value="<?php echo $_SERVER['HTTP_REFERER']; ?>">
            <h2>Modifier le post</h2>
            <div class="mb-3">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="postID" value="<?php echo htmlspecialchars($data['id']); ?>">
                <label for="title" class="form-label">Titre :</label>
                <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($data['titre']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Message :</label>
                <textarea name="content" class="form-control" rows="4" required><?php echo htmlspecialchars($data['texte']); ?></textarea>
            </div>
            <div class="mb-3">
                <input type="hidden" name="MAX_FILE_SIZE" value="5242880">
                <label for="postImage" class="form-label">Image (facultative) :</label>
                <input type="file" name="postImage" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Modifier le post</button>
        </form>

        <form action="./processPost.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ?')">
            <input type="hidden" name="redirect_url" value="<?php echo $_SERVER['HTTP_REFERER']; ?>">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="postID" value="<?php echo htmlspecialchars($data['id']); ?>">
            <button type="submit" class="btn btn-danger">Supprimer</button>
        </form>
<?php
    } else {
        echo '<div class="alert alert-danger">Erreur! Aucune correspondance pour cet ID de post.</div>';
    }
}

echo '</div>';

include(__ROOT__ . "/codePart/footer.php");
