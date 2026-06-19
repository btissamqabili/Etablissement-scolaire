<?php
include("../../config/config.php");

$id = $_GET['id'];

$sql = "SELECT * FROM classe WHERE id_classe=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

$classe = $stmt->fetch();

if(isset($_POST['modifier'])){

    $nom_classe = $_POST['nom_classe'];
    $annee_scolaire = $_POST['ann_scolaire'];
    $capacite_max = $_POST['capacite_max'];

    $sql = "UPDATE classe
            SET nom_classe=?,
                ann_scolaire=?,
                capacite_max=?
            WHERE id_classe=?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $nom_classe,
        $annee_scolaire,
        $capacite_max,
        $id
    ]);

    header("Location: liste.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier Classe</title>
</head>
<body>

<h2>Modifier une classe</h2>

<form method="POST">

Nom Classe :
<input type="text"
name="nom_classe"
value="<?= $classe['nom_classe'] ?>">

<br><br>

Année scolaire :
<input type="text"
name="annee_scolaire"
value="<?= $classe['ann_scolaire'] ?>">

<br><br>

Capacité :
<input type="number"
name="capacite_max"
value="<?= $classe['capacite_max'] ?>">

<br><br>

<button type="submit" name="modifier">
Modifier
</button>

</form>

</body>
</html>