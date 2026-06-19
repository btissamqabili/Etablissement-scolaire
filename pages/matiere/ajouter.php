<?php
include("../../config/config.php");

if(isset($_POST['ajouter'])){

    $nom_matiere = $_POST['nom_matiere'];

    $sql = "INSERT INTO matiere (nom_matiere)
            VALUES (?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom_matiere]);

    header("Location: liste.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter une matière</title>
</head>
<body>

<h2>Ajouter une matière</h2>

<form method="POST">

    Nom matière :
    <input type="text" name="nom_matiere" required>

    <br><br>

    <button type="submit" name="ajouter">
        Ajouter
    </button>

</form>

</body>
</html>