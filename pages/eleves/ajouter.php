<?php
require_once '../../config/config.php';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom    = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $date_n = $_POST['date_naissance'];
    $email  = trim($_POST['email']);

    if (empty($nom))    $errors[] = "Le nom est obligatoire.";
    if (empty($prenom)) $errors[] = "Le prénom est obligatoire.";
    if (empty($date_n)) $errors[] = "La date de naissance est obligatoire.";

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO eleve (nom, prenom, date_naissance, email) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nom, $prenom, $date_n, $email ?: null]);
        header("Location: liste.php?msg=ajoute");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Élève</title>
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
        <a href="liste.php" class="btn btn-sm btn-light me-2"><i class="bi bi-people me-1"></i>Élèves</a>
        <a href="../inscriptions/liste.php" class="btn btn-sm btn-outline-light"><i class="bi bi-journal-text me-1"></i>Inscriptions</a>
    </div>
</nav>

<div class="container" style="max-width: 600px;">
    <div class="d-flex align-items-center mb-3">
        <a href="liste.php" class="btn btn-outline-secondary btn-sm me-3"><i class="bi bi-arrow-left"></i></a>
        <h4 class="mb-0 fw-bold text-primary"><i class="bi bi-person-plus me-2"></i>Ajouter un Élève</h4>
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
            <form method="POST" action="ajouter.php">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nom <span class="text-danger">*</span></label>
                    <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Prénom <span class="text-danger">*</span></label>
                    <input type="text" name="prenom" class="form-control" value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Date de naissance <span class="text-danger">*</span></label>
                    <input type="date" name="date_naissance" class="form-control" value="<?= htmlspecialchars($_POST['date_naissance'] ?? '') ?>" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Enregistrer</button>
                    <a href="liste.php" class="btn btn-secondary"><i class="bi bi-x-circle me-1"></i>Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>