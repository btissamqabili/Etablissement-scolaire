<?php
require_once '../../config/config.php';

if (!isset($_GET['id'])) {
    header("Location: liste.php");
    exit;
}

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM inscription WHERE id_inscription = ?");
$stmt->execute([$id]);
$insc = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$insc) {
    header("Location: liste.php");
    exit;
}

$eleves  = $pdo->query("SELECT id_eleve, nom, prenom FROM eleve ORDER BY nom, prenom")->fetchAll(PDO::FETCH_ASSOC);
$classes = $pdo->query("SELECT id_classe, nom_classe FROM classe ORDER BY nom_classe")->fetchAll(PDO::FETCH_ASSOC);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_eleve  = (int)$_POST['id_eleve'];
    $id_classe = (int)$_POST['id_classe'];
    $date_insc = $_POST['date_inscription'];

    if (!$id_eleve)  $errors[] = "Veuillez choisir un élève.";
    if (!$id_classe) $errors[] = "Veuillez choisir une classe.";
    if (empty($date_insc)) $errors[] = "La date d'inscription est obligatoire.";

    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE inscription SET date_inscription=?, id_eleve=?, id_classe=? WHERE id_inscription=?");
        $stmt->execute([$date_insc, $id_eleve, $id_classe, $id]);
        header("Location: liste.php?msg=modifie");
        exit;
    }

    $insc = array_merge($insc, ['id_eleve' => $id_eleve, 'id_classe' => $id_classe, 'date_inscription' => $date_insc]);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f0f4f8; }
        .card { border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
        .navbar-custom { background: #1a3c5e; }
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

<div class="container" style="max-width: 600px;">
    <div class="d-flex align-items-center mb-3">
        <a href="liste.php" class="btn btn-outline-secondary btn-sm me-3"><i class="bi bi-arrow-left"></i></a>
        <h4 class="mb-0 fw-bold text-warning"><i class="bi bi-pencil-square me-2"></i>Modifier l'Inscription</h4>
    </div>

    <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="modifier.php?id=<?= $id ?>">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Élève <span class="text-danger">*</span></label>
                    <select name="id_eleve" class="form-select" required>
                        <option value="">-- Choisir un élève --</option>
                        <?php foreach ($eleves as $e): ?>
                            <option value="<?= $e['id_eleve'] ?>"
                                <?= $insc['id_eleve'] == $e['id_eleve'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($e['nom'] . ' ' . $e['prenom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Classe <span class="text-danger">*</span></label>
                    <select name="id_classe" class="form-select" required>
                        <option value="">-- Choisir une classe --</option>
                        <?php foreach ($classes as $c): ?>
                            <option value="<?= $c['id_classe'] ?>"
                                <?= $insc['id_classe'] == $c['id_classe'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($c['nom_classe']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Date d'inscription <span class="text-danger">*</span></label>
                    <input type="date" name="date_inscription" class="form-control"
                           value="<?= htmlspecialchars($insc['date_inscription']) ?>" required>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning"><i class="bi bi-save me-1"></i>Modifier</button>
                    <a href="liste.php" class="btn btn-secondary"><i class="bi bi-x-circle me-1"></i>Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>