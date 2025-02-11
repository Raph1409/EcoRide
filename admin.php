<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <link href="/style/styleIndex.css" rel="stylesheet">
    <link href="/style/styleAdmin.css" rel="stylesheet">
    <title>EcoRide</title>
</head>

<?php session_start(); ?>

<header>

    <?php require_once "script/scriptHeader.php"; ?>


</header>

<body>

    <?php require_once "front/bigTitle.php"; ?>
    <h2>Administration</h2>
    <div class="body mx-auto">
        <p>Connexion réussie ! Bienvenue
            <?php echo $_SESSION["user"]["prenom"] ."," . "<br>" ." Vous êtes connecté en tant qu'Administrateur" . "<br>" . "sous le pseudo : "  . $_SESSION["user"]["pseudo"] . "<br>" ?>
        </p>
        <button class="button" onclick="window.location.href = '../script/deconnexion.php';"> Déconnexion </button>
    </div>

    <div class="card mx-auto w-50">

        <h2>Créditer un utilisateur</h2>
        <?php require_once 'forms/creditForm.php'; ?>

    </div>

    <div class="container">
        <div class="col-sm-6">
            <div class="card">
                <h2>Créer un compte employé(e)</h2>
                <?php require_once 'forms/registerEmploye.php'; ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <h2>Suspendre un compte</h2>
                <?php require_once 'forms/selectCompteForm.php'; ?>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="col-sm-6">
            <div class="card">
                <h2>Nombre de covoiturages par jour</h2>
                <img src="../script/graphique1.php" alt="Graphique des covoiturages">
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <h2>Gains de la plateforme par jour</h2>
                <img src="../script/graphique2.php" alt="Graphique des covoiturages">
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card mx-auto">

            <?php require_once 'script/compteur.php'; ?>

        </div>
    </div>

</body>

<footer>

    <?php require_once "front/footer.php";?>

</footer>