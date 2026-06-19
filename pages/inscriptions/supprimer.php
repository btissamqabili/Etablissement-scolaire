<?php
require_once '../../config/config.php';

if (!isset($_GET['id'])) {
    header("Location: liste.php");
    exit;
}

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("DELETE FROM inscription WHERE id_inscription = ?");
$stmt->execute([$id]);

header("Location: liste.php?msg=supprime");
exit;