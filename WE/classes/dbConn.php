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
            $nom = $this->sanitize($_POST["name"]);
            $prenom = $this->sanitize($_POST["firstname"]);
            $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
            $mdp = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $date_naissance = $this->sanitize($_POST["birth"]);
            $adresse = $this->sanitize($_POST["adresse"]);
            $cp = (int)$_POST["codepostal"];
            $commune = $this->sanitize($_POST["commune"]);

            if ($email === false) {
                $error = "Format d'email invalide.";
            } else {
                $avatarUrl = "";
                if (isset($_FILES["avatar"]) && $_FILES["avatar"]["size"] > 0) {
                    $uploader = new ImgFileUploader($this,true); 
                    echo $uploader->errorText;
                    $avatarUrl = $uploader->saveFileAsNewAvatar(); 
                }

                $stmt = $this->db->prepare(
                    "INSERT INTO user (nom, prenom, email, mdp, date_naissance, adresse, cp, commune, url_avatar) 
                     VALUES (:nom, :prenom, :email, :mdp, :date_naissance, :adresse, :cp, :commune, :url_avatar)"
                );

                $stmt->bindParam(':nom', $nom);
                $stmt->bindParam(':prenom', $prenom);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':mdp', $mdp);
                $stmt->bindParam(':date_naissance', $date_naissance);
                $stmt->bindParam(':adresse', $adresse);
                $stmt->bindParam(':cp', $cp);
                $stmt->bindParam(':commune', $commune);
                $stmt->bindParam(':url_avatar', $avatarUrl);

                if ($stmt->execute()) {
                    $successful = true;

                    $stmt = $this->db->prepare("SELECT id FROM user WHERE email = :email");
                    $stmt->bindParam(':email', $email);
                    $stmt->execute();        
                    if ($stmt->rowCount() > 0) {
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        $_SESSION['id'] = $row['id'];
                    }
                } else {
                    $error = "Échec de création de compte.";
                }
            }
        }
    }

    return [$attempted, $successful, $error];
}


    function GetBlogOwnerFromID($ID, $connectedGuyName) {
        $query = "SELECT `nom`, `url_avatar` FROM `user` WHERE `id` = :ID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ID', $ID, PDO::PARAM_INT); 
        $stmt->execute();
        //echo "t1";
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row["nom"] === $connectedGuyName) {
                return array($connectedGuyName,$row["url_avatar"],true); 
            } else {
                return array($row["nom"],$row["url_avatar"],false); 
            }
        } else {
           // echo "invalid";
            return array("Invalide", "/default_avatar.ico", false);
        }
    }

    function GenerateHTML_forPostsPage($ownerID, $ownerName, $avatarOwner, $isMyBlog)
    {
        $query = "SELECT * FROM `post` WHERE `id_owner` = :ownerID ORDER BY `date` DESC LIMIT 5";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ownerID', $ownerID, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            if ($isMyBlog) {
                echo '
                <form action="post.php" method="POST">
                    <input type="hidden" name="newPost" value="1">
                    <button type="submit">Ajoute un nouveau post </button>
                </form>';
            }
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $postOBJ = new postStorage($row);
			    $postOBJ->DisplayToHTML($ownerName, $avatarOwner,$ownerID,$isMyBlog);
            }
        } else {
            echo '<p>Il n\'y a pas encore de post sur cette page</p>';

            if ($isMyBlog) {
                echo '
                <form action="post.php" method="POST">
                    <input type="hidden" name="newPost" value="1">
                    <button type="submit">Ajoute ton premier post </button>
                </form>';
            }
        }
    }


    function disconnect()
    {
        $this->db = null;
    }
}
