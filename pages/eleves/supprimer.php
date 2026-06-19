<?php
require_once '../../config/config.php';

if (!isset($_GET['id'])) {
    header("Location: liste.php");
    exit;
}

$id = (int)$_GET['id'];

// Supprimer inscriptions liées (clé étrangère)
$stmt = $pdo->prepare("DELETE FROM inscription WHERE id_eleve = ?");
$stmt->execute([$id]);

// Supprimer l'élève
$stmt = $pdo->prepare("DELETE FROM eleve WHERE id_eleve = ?");
$stmt->execute([$id]);

header("Location: liste.php?msg=supprime");
exit;