<?php
require_once '../../config/config.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matricule = trim($_POST['matricule']);
    $nom       = trim($_POST['nom']);
    $email     = trim($_POST['email']);

    if (empty($matricule)) $errors[] = "Le matricule est obligatoire.";
    if (empty($nom))       $errors[] = "Le nom est obligatoire.";
    if (empty($email))     $errors[] = "L'email est obligatoire.";

    if (empty($errors)) {
        // Vérifier unicité matricule et email
        $chk = $pdo->prepare("SELECT COUNT(*) FROM enseignant WHERE matricule=? OR email=?");
        $chk->execute([$matricule, $email]);
        if ($chk->fetchColumn() > 0) {
            $errors[] = "Ce matricule ou cet email existe déjà.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO enseignant (matricule, nom, email) VALUES (?, ?, ?)");
            $stmt->execute([$matricule, $nom, $email]);
            header("Location: liste.php?msg=ajoute");
            exit;
        }
    }
}
?>
<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/navbar.php'; ?>

<div class="container mt-4" style="max-width:600px">
    <div class="d-flex align-items-center mb-3">
        <a href="liste.php" class="btn btn-outline-secondary btn-sm me-3"><i class="bi bi-arrow-left"></i></a>
        <h4 class="mb-0 fw-bold text-primary"><i class="bi bi-person-plus me-2"></i>Ajouter un Enseignant</h4>
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

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="ajouter.php">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Matricule <span class="text-danger">*</span></label>
                    <input type="text" name="matricule" class="form-control"
                           value="<?= htmlspecialchars($_POST['matricule'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nom <span class="text-danger">*</span></label>
                    <input type="text" name="nom" class="form-control"
                           value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control"
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Enregistrer</button>
                    <a href="liste.php" class="btn btn-secondary"><i class="bi bi-x-circle me-1"></i>Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
