<?php session_start(); ?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/style/styleFormLogin.css" rel="stylesheet">
    <link href="/style/styleBigTitle.css" rel="stylesheet">
    <link href="/style/styleIndex.css" rel="stylesheet">
    <title>Confirmation</title>
</head>

<header>
    <?php 
    require_once '../script/scriptHeader.php';
    require '../front/bigTitle.php';
    ?>
</header>

<body>
    <h2>Accès refusé !</h2>
    <div class="formLogin mx-auto">
        <p>Désolé, vous n'avez pas les permissions pour voir cette page..</p>
        <a href="../forms/login.php">Se connecter</a><br>
        <a href="../index.php">Retour</a>
    </div>
</body>