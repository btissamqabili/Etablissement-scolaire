<?php
require_once '../../config/config.php';

$message = '';
$messageType = '';
if (isset($_GET['msg'])) {
    $msgs = [
        'ajoute'   => ['Inscription ajoutée avec succès.', 'success'],
        'modifie'  => ['Inscription modifiée avec succès.', 'success'],
        'supprime' => ['Inscription supprimée avec succès.', 'danger'],
    ];
    if (isset($msgs[$_GET['msg']])) {
        [$message, $messageType] = $msgs[$_GET['msg']];
    }
}

$inscriptions = $pdo->query("
    SELECT i.id_inscription, i.annee_scolaire,
           e.nom, e.prenom,
           c.nom_classe
    FROM inscription i
    JOIN eleve e ON i.id_eleve = e.id_eleve
    JOIN classe c ON i.id_classe = c.id_classe
    ORDER BY i.annee_scolaire DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Inscriptions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f0f4f8; }
        .card { border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
        .navbar-custom { background: #1a3c5e; }
        .btn-action { width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center; }
        .badge-classe { background: #e8f4fd; color: #0d6efd; border: 1px solid #b3d9f7; }
    </style>
</head>
<body>
<nav class="navbar navbar-custom navbar-dark px-4 py-2 mb-4">
    <span class="navbar-brand fw-bold"><i class="bi bi-mortarboard-fill me-2"></i>Gestion Scolaire</span>
    <div>
        <a href="../eleves/liste.php" class="btn btn-sm btn-outline-light me-2"><i class="bi bi-people me-1"></i>Élèves</a>
        <a href="liste.php" class="btn btn-sm btn-light"><i class="bi bi-journal-text me-1"></i>Inscriptions</a>
    </div>
</nav>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold" style="color:#1a3c5e"><i class="bi bi-journal-text me-2"></i>Liste des Inscriptions</h4>
        <a href="ajouter.php" class="btn btn-success">
            <i class="bi bi-journal-plus me-1"></i>Ajouter une inscription
        </a>
    </div>

    <?php if ($message): ?>
    <div class="alert alert-<?= $messageType ?> alert-dismissible fade show">
        <?= htmlspecialchars($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Élève</th>
                            <th>Classe</th>
                            <th>Date d'inscription</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($inscriptions)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Aucune inscription enregistrée.</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($inscriptions as $i): ?>
                        <tr>
                            <td><span class="badge bg-secondary"><?= $i['id_inscription'] ?></span></td>
                            <td><i class="bi bi-person-circle me-1 text-primary"></i>
                                <strong><?= htmlspecialchars($i['nom']) ?></strong> <?= htmlspecialchars($i['prenom']) ?>
                            </td>
                            <td><span class="badge badge-classe px-2 py-1"><?= htmlspecialchars($i['nom_classe']) ?></span></td>
                            <td><i class="bi bi-calendar3 me-1 text-muted"></i><?= htmlspecialchars($i['annee_scolaire']) ?></td>
                            <td class="text-center">
                                <a href="modifier.php?id=<?= $i['id_inscription'] ?>" class="btn btn-warning btn-action me-1" title="Modifier">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="supprimer.php?id=<?= $i['id_inscription'] ?>" class="btn btn-danger btn-action" title="Supprimer"
                                   onclick="return confirm('Supprimer cette inscription ?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>