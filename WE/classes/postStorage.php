<?php

class postStorage
{
    private $ID;
    private $titre;
    private $dateModif;
    private $contenu;
    private $imgPath;

    function __construct($row)
    {
        $this->ID = $row["id"];
        $this->titre = $row["titre"];
        $this->dateModif = $row["date"];
        $this->contenu = $row["texte"];
        $this->imgPath = $row["url_image"];
    }

    function DisplayToHTML($ownerName, $isMyBlog)
    {
        $timestamp = strtotime($this->dateModif);

        echo '<div class="blogPost"><div class="postTitle">';

        if ($isMyBlog) {
            echo '<div class="postModify">
                    <form action="post.php" method="GET">
                        <input type="hidden" name="postID" value="' . htmlspecialchars($this->ID) . '">
                        <button type="submit">Modifier/effacer</button>
                    </form>
                  </div>';
        } else {
            echo '<div class="postAuthor">par ' . htmlspecialchars($ownerName) . '</div>';
        }

        echo '<h3>•' . htmlspecialchars($this->titre) . '</h3>';
        echo '<p>dernière modification le ' . date("d/m/y à h:i:s", $timestamp) . '</p></div>';

        if (isset($this->imgPath) && $this->imgPath !== "") {
            $thumbPath = $this->GetThumbnailPath($this->imgPath);
            echo '<img class="postImg" src="' . htmlspecialchars($thumbPath) . '">';
        }

        echo '<p class="postContent">' . htmlspecialchars($this->contenu) . '</p>';
        echo '<div style="clear:both; height:0px; margin:0; padding:0"></div></div>';
    }

    function GetThumbnailPath($originalPath)
    {
        $pathFragments = pathinfo($originalPath);
        $result = $pathFragments['dirname'] . "/" . $pathFragments['filename'] . "_thumb.png";
        return $result;
    }
}
