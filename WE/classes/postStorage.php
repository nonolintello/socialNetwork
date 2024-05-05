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



    function DisplayToHTML($ownerName, $avatarOwner, $ownerID, $isMyBlog)
{
    $timestamp = strtotime($this->dateModif);

    echo '<div class="card mb-3">'; // Carte pour chaque post
    echo '<div class="card-header">'; // En-tête de la carte
    
    // Lien vers le profil avec l'avatar
    echo '<a href="' . DIR . '/blog.php?id=' . htmlspecialchars($ownerID) . '">';
    echo '<img src="' . htmlspecialchars($avatarOwner) . '" alt="Avatar de ' . htmlspecialchars($ownerName) . '" class="rounded-circle" style="width: 50px; height: 50px;">';
    echo '</a>';
    
    // Si c'est mon blog, ajoute les boutons de modification
    if ($isMyBlog) {
        echo '<div class="float-end">'; // Positionnement à droite
        echo '<form action="post.php" method="GET">';
        echo '<input type="hidden" name="postID" value="' . htmlspecialchars($this->ID) . '">';
        echo '<button type="submit" class="btn btn-sm btn-primary">Modifier/effacer</button>';
        echo '</form>';
        echo '</div>';
    } else {
        // Auteur du post
        echo '<div class="float-end">par ' . htmlspecialchars($ownerName) . '</div>';
    }
    
    echo '</div>'; // Fin de l'en-tête de la carte
    
    // Contenu du post
    echo '<div class="card-body">';
    echo '<h5 class="card-title">' . htmlspecialchars($this->titre) . '</h5>';
    echo '<p class="card-text">' . htmlspecialchars($this->contenu) . '</p>';
    
    // Miniature de l'image, si elle existe
    if (isset($this->imgPath) && $this->imgPath !== "") {
        $thumbPath = $this->GetThumbnailPath($this->imgPath);
        echo '<img src="./' . htmlspecialchars($thumbPath) . '" alt="Image du post" class="img-fluid mb-2">';
    }
    
    // Date de la dernière modification
    echo '<p class="text-muted">Dernière modification le ' . date("d/m/y à h:i:s", $timestamp) . '</p>';
    
    echo '</div>'; // Fin du corps de la carte
    echo '</div>'; // Fin de la carte
}


    function GetThumbnailPath($originalPath)
    {
        $pathFragments = pathinfo($originalPath);
        $result = $pathFragments['dirname'] . "/" . $pathFragments['filename'] . "_thumb.png";
        return $result;
    }
}
