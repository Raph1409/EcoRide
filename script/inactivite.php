<?php session_start(); ?>

<head>
    <meta charset="UTF-8">
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
    <h2>Inactivité !</h2>
    <div class="formLogin mx-auto">
        <p>Vous avez été déconnecter pour inactivité ! Veuillez vous reconecter.</p>
        <a href="../forms/login.php">Se reconnecter</a><br>
        <a href="../index.php">Retour à l'accueil</a><br>
    </div>
</body>