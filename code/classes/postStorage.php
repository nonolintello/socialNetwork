<?php

class postStorage
{
    public $ID;
    private $titre;
    private $dateModif;
    private $contenu;
    private $imgPath;
    private $nbLike;
    private $hasLiked;


    function __construct($row)
    {
        $this->ID = $row["id"];
        $this->titre = $row["titre"];
        $this->dateModif = $row["date"];
        $this->contenu = $row["texte"];
        $this->imgPath = isset($row["url_image"]) ? $row["url_image"] : "";
        $this->nbLike = isset($row["nbLike"]) ? $row["nbLike"] : 0;
        $this->hasLiked = isset($row["hasLiked"]) && $row["hasLiked"] > 0;
    }





    function DisplayToHTML($ownerName, $avatarOwner, $ownerID, $isMyBlog, $isReply, $ownerIsAdmin)
    {
        global $dbConn;  // 确保能够访问到$dbConn实例
        $currentUserID = $_SESSION['id'] ?? 0;
        $isAdmin = $dbConn->isAdmin($currentUserID);

        $timestamp = strtotime($this->dateModif);
        $adminMarkup = $ownerIsAdmin ? '<img src="images/avatar/admin.png" alt="Admin" class="rounded-circle" style="width: 40px; height: 40px;">' : '';
        if ($isReply) {
            echo '<div class="ms-5 ps-3 bg-secondary text-dark border-start border-primary">';
        }
        echo '<div class="card mb-3">';
        echo '<div class="card-header">';

        echo '<a href="' . DIR . '/blog.php?id=' . htmlspecialchars($ownerID) . '">';
        echo '<img src="' . htmlspecialchars($avatarOwner) . '" alt="Avatar de ' . htmlspecialchars($ownerName) . '" class="rounded-circle" style="width: 50px; height: 50px;">';
        echo $adminMarkup;  // Admin status displayed here
        
        echo '</a>';

        if ($isAdmin && !$isMyBlog) {  // 如果当前用户是管理员且不是查看自己的帖子
            echo "<div class='dropdown'>";
            echo "<button class='btn btn-secondary dropdown-toggle' type='button' id='adminOptions{$this->ID}' data-bs-toggle='dropdown' aria-expanded='false'>Gérer</button>";
            echo "<ul class='dropdown-menu' aria-labelledby='adminOptions{$this->ID}'>";
            // 这里是点击发送警告的功能
            echo "<li><a class='dropdown-item' href='#' onclick='openWarningForm(" . $this->ID . ", " . $ownerID . ")'>Avertir ce post</a></li>";
            // 敏感内容标记和删除功能
            echo "<li><a class='dropdown-item' href='#' onclick='openSensibleForm(" . $this->ID . ", " . $ownerID . ")'>Marquer comme sensible</a></li>";
            echo "<li><a class='dropdown-item' href='#' onclick='openRemovedForm(" . $this->ID . ", " . $ownerID . ")'>Supprimez ce message dangereux</a></li>";
            echo "</ul>";
            echo "</div>";
        }
        

        if ($isMyBlog) {
            echo '<div class="float-end">';
            echo '<form action="post.php" method="GET">';
            echo '<input type="hidden" name="postID" value="' . htmlspecialchars($this->ID) . '">';
            echo '<button type="submit" class="btn btn-sm btn-primary">Modifier/effacer</button>';
            echo '</form>';
            echo '</div>';
        } else {
            echo '<div class="float-end">par ' . htmlspecialchars($ownerName) . '</div>';
        }

        echo '</div>';

        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . htmlspecialchars($this->titre) . '</h5>';
        echo '<p class="card-text">' . htmlspecialchars($this->contenu) . '</p>';

        if (isset($this->imgPath) && $this->imgPath !== "") {
            $thumbPath = $this->GetThumbnailPath($this->imgPath);
            echo '<img src="./' . htmlspecialchars($thumbPath) . '" alt="Image du post" class="img-fluid mb-2">';
        }

        echo '<p class="text-muted">Dernière modification le ' . date("d/m/y à h:i:s", $timestamp) . '</p>';

        if (isset($_SESSION['id'])) {
            if ($this->hasLiked) {
                $likedClass = ' liked';
            } else {
                $likedClass = '';
            }

            echo '<button class="btn btn-sm btn-light like-button' . $likedClass . '" data-post-id="' . htmlspecialchars($this->ID) . '">';
            echo '<i class="fa fa-thumbs-up"></i> <span id="like-count-' . htmlspecialchars($this->ID) . '">' . htmlspecialchars($this->nbLike) . '</span>';
            echo '</button>';
            if ($isReply == false) {
                echo '<div class="float-end"><button class="btn btn-sm btn-primary" onclick="showReplyForm(' . htmlspecialchars($this->ID) . ')">Répondre à ce post</button></div>';
                echo '<div id="replyContainer' . htmlspecialchars($this->ID) . '"></div>';
            }
        } else {
            echo '<button class="btn btn-sm btn-light" onclick="showLoginPrompt()">';
            echo '<i class="fa fa-thumbs-up"></i> <span id="like-count-' . htmlspecialchars($this->ID) . '">' . htmlspecialchars($this->nbLike) . '</span>';
            echo '</button>';
        }


        echo '</div>';
        echo '</div>';

        if ($isReply) {
            echo '
            </div>';
        }
    }




    function GetThumbnailPath($originalPath)
    {
        $pathFragments = pathinfo($originalPath);
        $result = $pathFragments['dirname'] . "/" . $pathFragments['filename'] . "_thumb.png";
        return $result;
    }
}
