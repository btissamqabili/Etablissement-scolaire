<?php
include("../../config/config.php");

$id = $_GET['id'];

$sql = "DELETE FROM matiere
        WHERE id_matiere = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

header("Location: liste.php");
exit();
?>