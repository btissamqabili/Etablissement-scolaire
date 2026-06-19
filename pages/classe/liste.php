<?php
include("../../config/config.php");

$sql = "SELECT * FROM classe";
$stmt = $pdo->query($sql);

$classe = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des classes</title>
</head>
<body>

<h2>Liste des classes</h2>

<a href="ajouter.php">Ajouter une classe</a>

<table border="1">

<tr>
    <th>ID</th>
    <th>Nom Classe</th>
    <th>Année scolaire</th>
    <th>Capacité</th>
    <th>Actions</th>
</tr>

<?php foreach($classe as $class){ ?>

<tr>

    <td><?= $class['id_classe'] ?></td>

    <td><?= htmlspecialchars($class['nom_classe']) ?></td>

    <td><?= htmlspecialchars($class['ann_scolaire']) ?></td>

    <td><?= $class['capacite_max'] ?></td>

    <td>
        <a href="modifier.php?id=<?= $class['id_classe'] ?>">Modifier</a>

        <a href="supprimer.php?id=<?= $class['id_classe'] ?>"
           onclick="return confirm('Supprimer cette classe ?')">
            Supprimer
        </a>
    </td>

</tr>

<?php } ?>

</table>

</body>
</html>