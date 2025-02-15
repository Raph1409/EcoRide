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
?>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <link href="/style/styleIndex.css" rel="stylesheet">
    <title>EcoRide</title>
</head>

<header>

    <?php require_once "script/scriptHeader.php"; ?>

</header>

<body>

    <?php require_once "front/bigTitle.php"; ?>
    <?php require_once "front/barreRecherche.php";?>
    <?php require_once "front/accueil.php";?>

</body>

<footer>

    <?php require_once "front/footer.php";?>

</footer>