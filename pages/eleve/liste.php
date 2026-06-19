<?php
require_once '../../config/config.php';

// Message flash
$message = '';
$messageType = '';
if (isset($_GET['msg'])) {
    $msgs = [
        'ajoute'    => ['Élève ajouté avec succès.', 'success'],
        'modifie'   => ['Élève modifié avec succès.', 'success'],
        'supprime'  => ['Élève supprimé avec succès.', 'danger'],
    ];
    if (isset($msgs[$_GET['msg']])) {
        [$message, $messageType] = $msgs[$_GET['msg']];
    }
}

$eleves = $pdo->query("SELECT * FROM eleve ORDER BY nom, prenom")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Élèves</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f0f4f8; }
        .card { border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
        .page-title { color: #1a3c5e; font-weight: 700; }
        .btn-action { width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center; }
        .navbar-custom { background: #1a3c5e; }
    </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-custom navbar-dark px-4 py-2 mb-4">
    <span class="navbar-brand fw-bold"><i class="bi bi-mortarboard-fill me-2"></i>Gestion Scolaire</span>
    <div>
        <a href="liste.php" class="btn btn-sm btn-light me-2"><i class="bi bi-people me-1"></i>Élèves</a>
        <a href="../inscriptions/liste.php" class="btn btn-sm btn-outline-light"><i class="bi bi-journal-text me-1"></i>Inscriptions</a>
    </div>
</nav>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="page-title"><i class="bi bi-people-fill me-2"></i>Liste des Élèves</h4>
        <a href="ajouter.php" class="btn btn-primary">
            <i class="bi bi-person-plus me-1"></i>Ajouter un élève
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
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Date de naissance</th>
                            <th>Email</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($eleves)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Aucun élève enregistré.</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($eleves as $e): ?>
                        <tr>
                            <td><span class="badge bg-secondary"><?= $e['id_eleve'] ?></span></td>
                            <td class="fw-semibold"><?= htmlspecialchars($e['nom']) ?></td>
                            <td><?= htmlspecialchars($e['prenom']) ?></td>
                            <td><?= htmlspecialchars($e['date_naissance']) ?></td>
                            <td>
                                <?php if ($e['email']): ?>
                                    <a href="mailto:<?= htmlspecialchars($e['email']) ?>"><?= htmlspecialchars($e['email']) ?></a>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="modifier.php?id=<?= $e['id_eleve'] ?>" class="btn btn-warning btn-action me-1" title="Modifier">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="supprimer.php?id=<?= $e['id_eleve'] ?>" class="btn btn-danger btn-action" title="Supprimer"
                                   onclick="return confirm('Supprimer cet élève et ses inscriptions ?')">
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