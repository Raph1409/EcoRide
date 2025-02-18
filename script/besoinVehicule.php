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
    <h2>Véhicule manquant !</h2>
    <div class="formLogin mx-auto">
        <p>Vous devez enregistrer un véhicule pour pouvoir créer un covoiturage en tant que chauffeur.</p>
        <a href="../forms/vehiculeForm.php">Ajouter un véhicule</a><br>
        <a href="../index.php">Retour</a>
    </div>
</body>