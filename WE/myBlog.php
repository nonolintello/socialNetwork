<?php
include("./ini.php");
include(__ROOT__. "/codePart/header.php"); 

echo '<br><br><br><br>';

$var = 2;
$query = "SELECT * FROM `user` WHERE `id` > :idWanted";
$stmt = $dbConn->db->prepare($query);
$stmt->bindParam(':idWanted', $var, PDO::PARAM_INT); // Spécifiez le type de paramètre
$stmt->execute();

// Obtenir tous les résultats
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtenir les résultats sous forme de tableau associatif

// Vérifiez s'il y a des résultats
if (count($rows) > 0) {
    foreach ($rows as $row) {
        // Parcourez chaque ligne et affichez son contenu
        foreach ($row as $key => $value) {
            echo htmlspecialchars($key) . ": " . $value . "<br>"; // Afficher la clé et la valeur
        }
        echo "<hr>"; // Séparateur entre les lignes
    }
} else {
    echo "Aucun résultat trouvé.";
}



?>

