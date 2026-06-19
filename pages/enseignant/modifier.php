<?php
require_once '../../config/config.php';

if (!isset($_GET['id'])) { header("Location: liste.php"); exit; }

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM enseignant WHERE id_enseignant = ?");
$stmt->execute([$id]);
$ens = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$ens) { header("Location: liste.php"); exit; }

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matricule = trim($_POST['matricule']);
    $nom       = trim($_POST['nom']);
    $email     = trim($_POST['email']);

    if (empty($matricule)) $errors[] = "Le matricule est obligatoire.";
    if (empty($nom))       $errors[] = "Le nom est obligatoire.";
    if (empty($email))     $errors[] = "L'email est obligatoire.";

    if (empty($errors)) {
        // Vérifier unicité sauf lui-même
        $chk = $pdo->prepare("SELECT COUNT(*) FROM enseignant WHERE (matricule=? OR email=?) AND id_enseignant != ?");
        $chk->execute([$matricule, $email, $id]);
        if ($chk->fetchColumn() > 0) {
            $errors[] = "Ce matricule ou cet email existe déjà.";
        } else {
            $stmt = $pdo->prepare("UPDATE enseignant SET matricule=?, nom=?, email=? WHERE id_enseignant=?");
            $stmt->execute([$matricule, $nom, $email, $id]);
            header("Location: liste.php?msg=modifie");
            exit;
        }
    }
    $ens = array_merge($ens, compact('matricule', 'nom', 'email'));
}
?>
<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/navbar.php'; ?>

<div class="container mt-4" style="max-width:600px">
    <div class="d-flex align-items-center mb-3">
        <a href="liste.php" class="btn btn-outline-secondary btn-sm me-3"><i class="bi bi-arrow-left"></i></a>
        <h4 class="mb-0 fw-bold text-warning"><i class="bi bi-pencil-square me-2"></i>Modifier l'Enseignant</h4>
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
            <form method="POST" action="modifier.php?id=<?= $id ?>">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Matricule <span class="text-danger">*</span></label>
                    <input type="text" name="matricule" class="form-control"
                           value="<?= htmlspecialchars($ens['matricule']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nom <span class="text-danger">*</span></label>
                    <input type="text" name="nom" class="form-control"
                           value="<?= htmlspecialchars($ens['nom']) ?>" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control"
                           value="<?= htmlspecialchars($ens['email']) ?>" required>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning"><i class="bi bi-save me-1"></i>Modifier</button>
                    <a href="liste.php" class="btn btn-secondary"><i class="bi bi-x-circle me-1"></i>Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
