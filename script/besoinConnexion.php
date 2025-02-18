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
    <h2>Connexion manquante !</h2>
    <div class="formLogin mx-auto">
        <p>Vous devez être connecté pour effectuer cette action !</p>
        <a href="../forms/login.php">Se connecter</a><br>
        <a href="../forms/register.php">Créer un compte</a><br>
        <a href="../index.php">Retour</a>
    </div>
</body>