<?php session_start();

    // Durée maximale d'inactivité (10 minutes)
    $inactive_duration = 600;

    // Vérifier si l'utilisateur est inactif
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $inactive_duration) {
        session_unset();
        session_destroy();
        header("Location: ../script/inactivite.php");
    exit;
    }

    // Mettre à jour l'heure de la dernière activité
    $_SESSION['last_activity'] = time();

    // Vérification de l'existence de la session et du rôle de l'utilisateur
    if (!isset($_SESSION["user"]) || ($_SESSION["user"]["role"] != 1 && $_SESSION["user"]["role"] != 2)) {
        header("Location: ../script/accesrefuser.php");
    exit;
    }
?>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/style/styleIndex.css" rel="stylesheet">
    <link href="/style/styleEmploye.css" rel="stylesheet">
    <link href="/style/styleCovoiturage.css" rel="stylesheet">
    <title>EcoRide</title>
</head>

<header>

    <?php require_once "script/scriptHeader.php"; ?>

</header>

<body>

    <?php require_once "front/bigTitle.php"; ?>
    <h2>Mon espace</h2>
    <div class="body mx-auto">
        <p>Connexion réussie ! Bienvenue
            <?php echo $_SESSION["user"]["prenom"] ."," . "<br>" ." Vous êtes connecté en tant qu'employé(e)" . "<br>" . "sous le pseudo : "  . $_SESSION["user"]["pseudo"] . "<br>" ?>
        </p>
        <button class="button" onclick="window.location.href = '../script/deconnexion.php';"> Déconnexion </button>
    </div>

    <?php require_once "script/mesinfos.php"; ?>

    <?php require_once "script/validationAvis.php"; ?>

</body>

<footer>

    <?php require_once "front/footer.php";?>

</footer>