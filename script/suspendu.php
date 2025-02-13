<head>
    <meta charset="UTF-8">
    <link href="/style/styleFormLogin.css" rel="stylesheet">
    <link href="/style/styleBigTitle.css" rel="stylesheet">
    <link href="/style/styleIndex.css" rel="stylesheet">
    <link href="/style/styleHeader.css" rel="stylesheet">
    <title>Confirmation</title>
</head>

<header>
    <?php
    session_start(); 
    require_once '../script/scriptHeader.php'; ?>
    <?php require '../front/bigTitle.php';?>
</header>

<body>
    <h2>Accès refusé !</h2>
    <div class="formLogin mx-auto">
        <p>Désolé, votre compte à été suspendu par un administrateur.. Veuillez nous contacter.</p>
        <a href="../front/contact.php">Nous contacter</a><br>
        <a href="../script/deconnexion.php">Retour</a>
    </div>
</body>

<footer>

    <?php require_once "../front/footer.php";?>

</footer>

</html>