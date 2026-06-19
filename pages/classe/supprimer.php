<?php

include("../../config/config.php");

$id = $_GET['id'];

$sql = "DELETE FROM classe WHERE id_classe=?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

header("Location: liste.php");