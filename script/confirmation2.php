<?php session_start(); ?>

<head>
    <meta charset="utf-8">
    <link href="/style/styleFormLogin.css" rel="stylesheet">
    <link href="/style/styleBigTitle.css" rel="stylesheet">
    <title>Confirmation de vote</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<header>
    <?php
    require_once '../script/scriptHeader.php'; ?>
    <?php require '../front/bigTitle.php';?>
</header>

<body>
    <div class="formLogin container mt-5">
        <div>
            <h4 class="label">Merci !</h4>
            <p class="label">Votre vote a bien été enregistré.</p>
            <p class="label">Le statut du covoiturage sera mis à jour lorsque tous les passagers auront voté.</p>
            <hr>
            <a href="../utilisateur.php">Retour à mon espace</a>
        </div>
    </div>
</body>

<footer>

    <?php require_once "../front/footer.php";?>

</footer>

</html>