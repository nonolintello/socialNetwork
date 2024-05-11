<?php

require_once(__ROOT__ . "/classes/loginStatus.php");
require_once(__ROOT__ . "/classes/postStorage.php");
require_once(__ROOT__ . "/classes/imageUpload.php");

class dbConn
{
    public $db = null;
    public $loginStatus = null;

    function __construct()
    {
        $server = "localhost";
        $database = "projet";
        $user = "root";
        $password = "";


        $dsn = "mysql:host=$server;dbname=$database;charset=utf8mb4";

        try {
            $this->db = new PDO($dsn, $user, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }

        $this->loginStatus = new LoginStatus($this);
    }

    function sanitize($input)
    {
        return htmlspecialchars(trim($input));
    }

    function handleAccountCreation()
    {
        $attempted = false;
        $successful = false;
        $error = null;
    
        if (
            isset($_POST["name"]) &&
            isset($_POST["firstname"]) &&
            isset($_POST["email"]) &&
            isset($_POST["password"]) &&
            isset($_POST["confirm"]) &&
            isset($_POST["birth"]) &&
            isset($_POST["adresse"]) &&
            isset($_POST["codepostal"]) &&
            isset($_POST["commune"])
        ) {
            $attempted = true;
    
            if ($_POST["password"] !== $_POST["confirm"]) {
                $error = "Les mots de passe ne correspondent pas.";
            } else {
                $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    
                if ($email === false) {
                    $error = "Format d'email invalide.";
                } else {
                    // Vérifier si l'email existe déjà
                    $stmt = $this->db->prepare("SELECT id FROM user WHERE email = :email");
                    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                    $stmt->execute();
    
                    if ($stmt->rowCount() > 0) {
                        $error = "Cette adresse e-mail est déjà utilisée.";
                    } else {
                        $nom = $this->sanitize($_POST["name"]);
                        $prenom = $this->sanitize($_POST["firstname"]);
                        $mdp = password_hash($_POST["password"], PASSWORD_DEFAULT);
                        $date_naissance = $this->sanitize($_POST["birth"]);
                        $adresse = $this->sanitize($_POST["adresse"]);
                        $cp = (int)$_POST["codepostal"];
                        $commune = $this->sanitize($_POST["commune"]);
                        $avatarUrl = "images/avatar/default_avatar.ico";
    
                        if (isset($_FILES["avatar"]) && $_FILES["avatar"]["size"] > 0) {
                            $uploader = new ImgFileUploader($this, true);
                            $avatarUrl = $uploader->saveFileAsNewAvatar();
                        }
    
                        $stmt = $this->db->prepare(
                            "INSERT INTO user (nom, prenom, email, mdp, date_naissance, adresse, cp, commune, url_avatar) 
                             VALUES (:nom, :prenom, :email, :mdp, :date_naissance, :adresse, :cp, :commune, :url_avatar)"
                        );
    
                        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
                        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
                        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                        $stmt->bindParam(':mdp', $mdp, PDO::PARAM_STR);
                        $stmt->bindParam(':date_naissance', $date_naissance, PDO::PARAM_STR);
                        $stmt->bindParam(':adresse', $adresse, PDO::PARAM_STR);
                        $stmt->bindParam(':cp', $cp, PDO::PARAM_INT);
                        $stmt->bindParam(':commune', $commune, PDO::PARAM_STR);
                        $stmt->bindParam(':url_avatar', $avatarUrl, PDO::PARAM_STR);
    
                        if ($stmt->execute()) {
                            $successful = true;
                            $stmt = $this->db->prepare("SELECT id, url_avatar FROM user WHERE email = :email");
                            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                            $stmt->execute();
    
                            if ($stmt->rowCount() > 0) {
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                $_SESSION['id'] = $row['id'];
                                $_SESSION['avatar'] = $row['url_avatar'];
                            }
                        } else {
                            $error = "Échec de création de compte.";
                        }
                    }
                }
            }
        }
    
        return [$attempted, $successful, $error];
    }
    


    function GetBlogINFOFromID($ID, $connectedGuyName)
    {
        $query = "SELECT `nom`, `url_avatar`, `bio`, `prenom`, `admin` FROM `user` WHERE `id` = :ID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ID', $ID, PDO::PARAM_INT);
        $stmt->execute();
        //echo "t1";
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row["nom"] === $connectedGuyName) {
                return array($connectedGuyName . ' ' . $row["prenom"], $row["url_avatar"], true, $row["bio"], $row["admin"]);
            } else {
                return array($row["nom"] . ' ' . $row["prenom"], $row["url_avatar"], false, $row["bio"], $row["admin"]);
            }
        } else {
            // echo "invalid";
            return array("Invalide", "/default_avatar.ico", false, "Biographie par défault");
        }
    }

    function GenerateHTML_forPostsPage($ownerID, $ownerName, $avatarOwner, $isMyBlog)
    {
        $currentUserID = isset($_SESSION['id']) ? $_SESSION['id'] : 0;


        $query = "SELECT post.*, user.admin AS isAdmin,
          (SELECT COUNT(*) FROM jaime WHERE jaime.id_post = post.id) AS nbLike,
          (SELECT COUNT(*) FROM jaime WHERE jaime.id_post = post.id AND jaime.id_user = :currentUserID) AS hasLiked
          FROM post 
          JOIN user ON user.id = post.id_owner 
          WHERE `id_owner` = :ownerID AND `id_parent` IS NULL AND `titre` <> 'Avertir!!!'AND post.titre <> 'Sensible!!!'AND post.titre <> 'Removed!!!'AND post.removed = 0
          ORDER BY post.date DESC 
          LIMIT 5";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':currentUserID', $currentUserID, PDO::PARAM_INT);
        $stmt->bindParam(':ownerID', $ownerID, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            if ($isMyBlog) {
                echo '<form action="post.php" method="POST">';
                echo '<input type="hidden" name="newPost" value="1">';
                echo '<button type="submit">Ajouter un nouveau post</button>';
                echo '</form>';
            }

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $postOBJ = new postStorage($row);
                $postOBJ->DisplayToHTML($ownerName, $avatarOwner, $ownerID, $isMyBlog, false, $row['isAdmin']);

                $this->GenerateReplies($postOBJ);
            }
        } else {
            echo '<p>Il n\'y a pas encore de post sur cette page</p>';

            if ($isMyBlog) {
                echo '<form action="post.php" method="POST">';
                echo '<input type="hidden" name="newPost" value="1">';
                echo '<button type="submit">Ajoute ton premier post</button>';
                echo '</form>';
            }
        }
    }

    function isAdmin($userID) {
        $stmt = $this->db->prepare("SELECT admin FROM user WHERE id = :userID");
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['admin'] == 1;
        }
        return false;
    }
    
    function GenerateReplies($parentPost)
    {
        $query = "SELECT post.*, user.admin AS isAdmin
              FROM post
              JOIN user ON user.id = post.id_owner
              WHERE post.id_parent = :parentID AND post.titre <> 'Avertir!!!'AND post.titre <> 'Sensible!!!' AND post.sensible = 0 AND post.titre <> 'Removed!!!'
              ORDER BY post.date ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':parentID', $parentPost->ID, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo '<div class="replies">';
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $blogOwner = $this->GetBlogINFOFromID($row['id_owner'], $this->loginStatus->userName);
                $blogOwnerName = htmlspecialchars($blogOwner[0]);
                $avatarOwner = $blogOwner[1];
                $isMyOwnBlog = $blogOwner[2];
                $replyPost = new postStorage($row);
                $replyPost->DisplayToHTML($blogOwnerName, $avatarOwner, $row['id_owner'], $isMyOwnBlog, true, $row['isAdmin']);
            }
            echo '</div>';
        }
    }


    function disconnect()
    {
        $this->db = null;
    }

    public function banUser($userID, $banDate) {
        $query = "UPDATE user SET banni = :banDate WHERE id = :userID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':banDate', $banDate, PDO::PARAM_STR);
    
        return $stmt->execute();
    }
    
}
