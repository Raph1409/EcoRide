<head>
    <meta charset="UTF-8">
    <link href="/style/styleFormLogin.css" rel="stylesheet">
    <link href="/style/styleBigTitle.css" rel="stylesheet">
    <title>Confirmation</title>
</head>

<header>
    <?php
    session_start(); 
    require_once '../script/scriptHeader.php'; ?>
    <?php require '../front/bigTitle.php';?>
</header>

<body>
    <h2>Administration</h2>
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="formLogin mx-auto">
        <h2>Succès</h2>
        <p>Le rôle du compte <strong><?= htmlspecialchars($_GET['pseudo']) ?></strong> a été mis à jour avec succès.</p>
        <a href="../admin.php">Retour</a>
    </div>
    <?php else: ?>
    <h2>Erreur</h2>
    <p>Une erreur s'est produite lors de la mise à jour du rôle.</p>
    <a href="../index.php">Retour à l'accueil</a>
    <?php endif; ?>
</body>

</html>