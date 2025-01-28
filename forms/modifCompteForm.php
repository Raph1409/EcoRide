<head>
    <link href="/style/styleFormLogin.css" rel="stylesheet">
</head>

<header>
    <?php
    session_start(); 
    require_once '../script/scriptHeader.php'; ?>
</header>

<body>
    <?php require '../front/bigTitle.php';
    
    //On récupère les données du formulaire modifAnimauxform 
    $compteForm = $_POST['compte'];?>

    <h2>Modification de <?php echo $compteForm; ?> </h2>

    <?php
require_once '../script/connexionBDD.php';

// Vérifiez si une clé "compte" est transmise via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['compte'])) {
    $pseudo = $_POST['compte'];

    // Récupérer les informations du compte
    $queryCompte = "SELECT pseudo, role FROM utilisateurs WHERE pseudo = :pseudo";
    $stmt = $pdo->prepare($queryCompte);
    $stmt->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
    $stmt->execute();
    $compte = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$compte) {
        die("Le compte sélectionné n'existe pas.");
    }

    // Récupérer tous les rôles disponibles
    $roles = $pdo->query("SELECT role_id, libelle FROM roles")->fetchAll(PDO::FETCH_ASSOC);
} else {
    die("Aucun compte sélectionné.");
}
?>

    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Modifier le rôle du compte</title>
    </head>

    <body>
        <h2>Administration</h2>
        <form class="formLogin mx-auto" action="modifCompteAction.php" method="POST">
            <input class="inputBasic" type="hidden" name="pseudo" value="<?= htmlspecialchars($compte['pseudo']) ?>">
            <label class="label" for="nouveau_role">Nouveau rôle :</label>
            <select name="nouveau_role" id="nouveau_role" required>
                <?php foreach ($roles as $role): ?>
                <option value="<?= htmlspecialchars($role['role_id']) ?>"
                    <?= $compte['role'] == $role['role_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($role['libelle']) ?>
                </option>
                <?php endforeach; ?>
            </select><br><br>
            <input type="submit" value="Mettre à jour">
        </form>
    </body>

    <footer>

        <?php require_once "../front/footer.php";?>

    </footer>

    </html>