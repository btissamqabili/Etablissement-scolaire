<?php
include("../../config/config.php");

$sql = "SELECT * FROM matiere";
$stmt = $pdo->query($sql);

$matiere = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des matières</title>
</head>
<body>

<h2>Liste des matières</h2>

<a href="ajouter.php">Ajouter une matière</a>

<table border="1">

<tr>
    <th>ID</th>
    <th>Nom matière</th>
    <th>Actions</th>
</tr>

<?php foreach($matiere as $matier){ ?>

<tr>

    <td><?= $matier['id_matiere'] ?></td>

    <td><?= htmlspecialchars($matier['nom_matiere']) ?></td>

    <td>
        <a href="modifier.php?id=<?= $matier['id_matiere'] ?>">
            Modifier
        </a>

        <a href="supprimer.php?id=<?= $matier['id_matiere'] ?>"
        onclick="return confirm('Supprimer cette matière ?')">
            Supprimer
        </a>
    </td>

</tr>

<?php } ?>

</table>

</body>
</html>