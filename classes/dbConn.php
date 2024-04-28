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

    function disconnect()
    {
        $this->db = null;
    }
}
?>
