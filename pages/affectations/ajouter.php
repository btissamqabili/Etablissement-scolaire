<?php
require_once '../../config/config.php';

$enseignants = $pdo->query("SELECT id_enseignant, matricule, nom FROM enseignant ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
$classes     = $pdo->query("SELECT id_classe, nom_classe FROM classe ORDER BY nom_classe")->fetchAll(PDO::FETCH_ASSOC);
$matieres    = $pdo->query("SELECT id_matiere, nom_matiere FROM matiere ORDER BY nom_matiere")->fetchAll(PDO::FETCH_ASSOC);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_enseignant = (int)$_POST['id_enseignant'];
    $id_classe     = (int)$_POST['id_classe'];
    $id_matiere    = (int)$_POST['id_matiere'];

    if (!$id_enseignant) $errors[] = "Veuillez choisir un enseignant.";
    if (!$id_classe)     $errors[] = "Veuillez choisir une classe.";
    if (!$id_matiere)    $errors[] = "Veuillez choisir une matière.";

    if (empty($errors)) {
        // Vérifier doublon
        $chk = $pdo->prepare("SELECT COUNT(*) FROM affectation WHERE id_enseignant=? AND id_classe=? AND id_matiere=?");
        $chk->execute([$id_enseignant, $id_classe, $id_matiere]);
        if ($chk->fetchColumn() > 0) {
            $errors[] = "Cette affectation existe déjà.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO affectation (id_enseignant, id_classe, id_matiere) VALUES (?, ?, ?)");
            $stmt->execute([$id_enseignant, $id_classe, $id_matiere]);
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
        <h4 class="mb-0 fw-bold text-primary"><i class="bi bi-plus-circle me-2"></i>Ajouter une Affectation</h4>
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
                    <label class="form-label fw-semibold">Enseignant <span class="text-danger">*</span></label>
                    <select name="id_enseignant" class="form-select" required>
                        <option value="">-- Choisir un enseignant --</option>
                        <?php foreach ($enseignants as $e): ?>
                            <option value="<?= $e['id_enseignant'] ?>"
                                <?= (isset($_POST['id_enseignant']) && $_POST['id_enseignant'] == $e['id_enseignant']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($e['nom'] . ' (' . $e['matricule'] . ')') ?>
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
                                <?= (isset($_POST['id_classe']) && $_POST['id_classe'] == $c['id_classe']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($c['nom_classe']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Matière <span class="text-danger">*</span></label>
                    <select name="id_matiere" class="form-select" required>
                        <option value="">-- Choisir une matière --</option>
                        <?php foreach ($matieres as $m): ?>
                            <option value="<?= $m['id_matiere'] ?>"
                                <?= (isset($_POST['id_matiere']) && $_POST['id_matiere'] == $m['id_matiere']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($m['nom_matiere']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
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
