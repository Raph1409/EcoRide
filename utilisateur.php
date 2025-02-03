<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <link href="/style/styleIndex.css" rel="stylesheet">
    <link href="/style/styleAdmin.css" rel="stylesheet">
    <link href="/style/styleCovoiturage.css" rel="stylesheet">
    <title>EcoRide</title>
</head>

<?php session_start(); ?>

<header>

    <?php require_once "script/scriptHeader.php"; ?>

</header>

<body>

    <?php require_once "front/bigTitle.php"; ?>
    <h2>Mon espace</h2>
    <div class="body mx-auto">
        <p>Connexion réussie ! Bienvenue
            <?php echo $_SESSION["user"]["prenom"] ."," . "<br>" ." Vous êtes connecté en tant qu'Utilisateur" . "<br>" . "sous le pseudo : "  . $_SESSION["user"]["pseudo"] . "<br>" ?>
        </p>
        <button class="button" onclick="window.location.href = '../script/deconnexion.php';"> Déconnexion </button>
    </div>

    <?php require_once "script/mesinfos.php"; ?>
    <?php require_once "script/mesvehicules.php"; ?><br>

    <?php require_once "script/historiqueChauffeur.php"; ?>
    <?php require_once "script/historiquePassager.php"; ?>

</body>

<footer>

    <?php require_once "front/footer.php";?>

</footer>