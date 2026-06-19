<?php
require_once '../../config/config.php';

$message = '';
$messageType = '';
if (isset($_GET['msg'])) {
    $msgs = [
        'ajoute'   => ['Enseignant ajouté avec succès.', 'success'],
        'modifie'  => ['Enseignant modifié avec succès.', 'success'],
        'supprime' => ['Enseignant supprimé avec succès.', 'danger'],
    ];
    if (isset($msgs[$_GET['msg']])) {
        [$message, $messageType] = $msgs[$_GET['msg']];
    }
}

$enseignants = $pdo->query("SELECT * FROM enseignant ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
?>
<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/navbar.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold" style="color:#1a3c5e"><i class="bi bi-person-badge me-2"></i>Liste des Enseignants</h4>
        <a href="ajouter.php" class="btn btn-primary">
            <i class="bi bi-person-plus me-1"></i>Ajouter un enseignant
        </a>
    </div>

    <?php if ($message): ?>
    <div class="alert alert-<?= $messageType ?> alert-dismissible fade show">
        <?= htmlspecialchars($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Matricule</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($enseignants)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Aucun enseignant enregistré.</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($enseignants as $e): ?>
                        <tr>
                            <td><span class="badge bg-secondary"><?= $e['id_enseignant'] ?></span></td>
                            <td><code><?= htmlspecialchars($e['matricule']) ?></code></td>
                            <td class="fw-semibold"><?= htmlspecialchars($e['nom']) ?></td>
                            <td><a href="mailto:<?= htmlspecialchars($e['email']) ?>"><?= htmlspecialchars($e['email']) ?></a></td>
                            <td class="text-center">
                                <a href="modifier.php?id=<?= $e['id_enseignant'] ?>" class="btn btn-warning btn-sm me-1" title="Modifier">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="supprimer.php?id=<?= $e['id_enseignant'] ?>" class="btn btn-danger btn-sm" title="Supprimer"
                                   onclick="return confirm('Supprimer cet enseignant ?')">
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

<?php require_once '../../includes/footer.php'; ?>
