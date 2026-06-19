<?php
include("../../config/config.php");

if (isset($_POST['ajouter'])) {

    $nom_classe = $_POST['nom_classe'];
    $ann_scolaire = $_POST['ann_scolaire'];
    $capacite_max = $_POST['capacite_max'];

    $sql = "INSERT INTO classe (nom_classe, ann_scolaire, capacite_max)
            VALUES (?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom_classe, $ann_scolaire, $capacite_max]);

    header("Location: liste.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter une classe</title>
</head>
<body>

<h2>Ajouter une classe</h2>

<form method="POST">

    <label>Nom Classe :</label>
    <input type="text" name="nom_classe" required>
    <br><br>

    <label>Année scolaire :</label>
    <input type="text" name="ann_scolaire" required>
    <br><br>

    <label>Capacité maximale :</label>
    <input type="number" name="capacite_max" required>
    <br><br>

    <button type="submit" name="ajouter">
        Ajouter
    </button>

</form>

</body>
</html>