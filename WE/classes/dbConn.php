<?php

require_once(__ROOT__ . "/classes/loginStatus.php");


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
                    $stmt = $this->db->prepare(
                        "INSERT INTO user (nom, prenom, email, mdp, date_naissance, adresse, cp, commune) 
                        VALUES (:nom, :prenom, :email, :mdp, :date_naissance, :adresse, :cp, :commune)"
                    );

                    $stmt->bindParam(':nom', $nom);
                    $stmt->bindParam(':prenom', $prenom);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':mdp', $mdp);
                    $stmt->bindParam(':date_naissance', $date_naissance);
                    $stmt->bindParam(':adresse', $adresse);
                    $stmt->bindParam(':cp', $cp);
                    $stmt->bindParam(':commune', $commune);

                    if ($stmt->execute()) {
                        $successful = true;
                    } else {
                        $error = "Échec de création de compte.";
                    }
                }
            }
        }

        return [$attempted, $successful, $error];
    }

  

    function GenerateHTML_forPostsPage($ownerID, $isMyBlog, $dbConn)
    {
        // Requête pour obtenir les 10 derniers posts du propriétaire
        $query = "SELECT * FROM `post` WHERE `id_owner` = :ownerID ORDER BY `date` DESC LIMIT 10";
        $stmt = $dbConn->db->prepare($query);
        $stmt->bindParam(':ownerID', $ownerID, PDO::PARAM_INT); // Assurez-vous que l'ID est traité comme un entier
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Afficher un bouton pour ajouter un nouveau post si c'est le propre blog de l'utilisateur
            if ($isMyBlog) {
                echo '
                <form action="editPost.php" method="POST">
                    <input type="hidden" name="newPost" value="1">
                    <button type="submit">Ajouter un nouveau post!</button>
                </form>';
            }

            // Afficher chaque post avec ses détails
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Utiliser les détails du post pour afficher
                echo "<div>";
                echo "<h2>Post ID: " . htmlspecialchars($row['id']) . "</h2>";
                echo "<p>Contenu: " . htmlspecialchars($row['texte']) . "</p>";
                echo "<p>Date: " . htmlspecialchars($row['date']) . "</p>";

                // Afficher une image si elle existe
                if (!empty($row['url_image'])) {
                    //echo DIR.htmlspecialchars($row['url_image']);
                    echo "<img src='." . htmlspecialchars($row['url_image']) . ".jpeg' alt='Post Image' />";
                }

                echo "</div>";
            }
        } else {
            // Si aucun post n'est trouvé, afficher un message
            echo '<p>Il n\'y a pas de post.</p>';

            if ($isMyBlog) {
                echo '
                <form action="editPost.php" method="POST">
                    <input type="hidden" name="newPost" value="1">
                    <button type="submit">Ajouter un premier post!</button>
                </form>';
            }
        }
    }




    function disconnect()
    {
        $this->db = null;
    }
}
?>
