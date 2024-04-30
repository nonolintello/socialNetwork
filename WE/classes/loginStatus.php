<?php
require_once(__ROOT__ . "/classes/dbConn.php");

class LoginStatus
{
    public $errorText = "";
    public $userName = "";
    public $userID = 0;
    public $userMail = "";
    public $loginSuccessful = false;
    public $loginAttempted = false;

    function __construct($dbConn)
    {


        $this->loginSuccessful = false;
        $password = "";
        if (isset($_SESSION['id'])) {
            $userID = $_SESSION['id'];
            $query = "SELECT * FROM user WHERE id = :ID ";
            $stmt = $dbConn->db->prepare($query);
            $stmt->bindParam(':ID', $userID);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->userName = $row["nom"];
                $this->userID = $row["id"];
                $this->userMail = $row["email"];
                $this->loginSuccessful = true;
            } else {
                $this->errorText = "Utilisateur non trouvé. Créez un compte.";
            }
        }
        if (isset($_POST["email"]) && isset($_POST["password"])) {
            $email = $dbConn->sanitize($_POST["email"]);
            $password = $_POST["password"];
            $this->loginAttempted = true;
        } else {
            $this->loginAttempted = false;
        }

        if ($this->loginAttempted) {
            $query = "SELECT * FROM user WHERE email = :email";
            $stmt = $dbConn->db->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($password, $row["mdp"])) {
                    $this->userID = $row["id"];
                    $this->userName = $row["nom"];
                    $_SESSION['id'] = $this->userID;
                    $this->userMail = $email;
                    $this->loginSuccessful = true;
                } else {
                    $this->errorText = "Mot de passe incorrect. Essayez encore.";
                }
            } else {
                $this->errorText = "Utilisateur non trouvé. Créez un compte.";
            }
        }
    }
}
