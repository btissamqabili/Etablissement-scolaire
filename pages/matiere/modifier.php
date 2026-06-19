<?php
include("../../config/config.php");

$id = $_GET['id'];

$sql = "SELECT * FROM matiere WHERE id_matiere = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

$matiere = $stmt->fetch();

if(isset($_POST['modifier'])){

    $nom_matiere = $_POST['nom_matiere'];

    $sql = "UPDATE matiere
            SET nom_matiere = ?
            WHERE id_matiere = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom_matiere, $id]);

    header("Location: liste.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier matière</title>
</head>
<body>

<h2>Modifier une matière</h2>

<form method="POST">

    Nom matière :

    <input type="text"
           name="nom_matiere"
           value="<?= htmlspecialchars($matiere['nom_matiere']) ?>"
           required>

    <br><br>

    <button type="submit" name="modifier">
        Modifier
    </button>

</form>

</body>
</html>