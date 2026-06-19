<?php
require_once '../../config/config.php';

if (!isset($_GET['id'])) { header("Location: liste.php"); exit; }

$id = (int)$_GET['id'];

// Vérifier si l'enseignant a des affectations
$chk = $pdo->prepare("SELECT COUNT(*) FROM affectation WHERE id_enseignant = ?");
$chk->execute([$id]);
if ($chk->fetchColumn() > 0) {
    header("Location: liste.php?msg=erreur");
    exit;
}

$stmt = $pdo->prepare("DELETE FROM enseignant WHERE id_enseignant = ?");
$stmt->execute([$id]);

header("Location: liste.php?msg=supprime");
exit;
