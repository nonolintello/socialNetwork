<?php
include("./ini.php");
include(__ROOT__ . "/codePart/header.php");


$query = "SELECT * FROM post ORDER BY date DESC LIMIT 10 ";
$stmt = $dbConn->db->prepare($query);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="container">
    <div class="d-flex justify-content-end mt-3 mb-3">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Trier par
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="?sort=date">Date</a>
                <a class="dropdown-item" href="?sort=popularity">Popularité</a>
            </div>
        </div>
    </div>


    <div class="posts">

        <?php
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'date';
        if ($sort == 'date') {
            foreach ($posts as $post) :
                $blogOwner = $dbConn->GetBlogOwnerFromID($post['id_owner'], $dbConn->loginStatus->userName);
                $blogOwnerName = htmlspecialchars($blogOwner[0]);
                $avatarOwner = $blogOwner[1];
                $dbConn->GenerateHTML_forPostsPage($post['id_owner'], $blogOwnerName, $avatarOwner, false);
            endforeach;
        } else if ($sort == 'popularity') {
            echo "Soon available...";
        }
        ?>
    </div>
</div>



<?php
include(__ROOT__ . "/codePart/footer.php");
?>
