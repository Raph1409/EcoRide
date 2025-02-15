<?php session_start(); 

    require_once '../script/connexionBDD.php';

    $queryEnergie = "SELECT * FROM energies";
    $stmt = $pdo->prepare($queryEnergie);
    $stmt->execute();

    $queryMarque = "SELECT * FROM marques";
    $stmt2 = $pdo->prepare($queryMarque);
    $stmt2->execute();

    $energies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $marques = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    $proprietaireId = "SELECT utilisateur_id FROM utilisateurs WHERE pseudo = :pseudo";
    $stmt3 = $pdo->prepare($proprietaireId);
    $stmt3->bindParam(":pseudo", $_SESSION["user"]["pseudo"]);
    $stmt3->execute();

    $proprietaire = $stmt3->fetch(PDO::FETCH_ASSOC);
    $proprietaireIdHidden = $proprietaire['utilisateur_id'];
?>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <meta charset="utf_8">
    <meta name="viewport" content="width=device-width, initial-script">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/style/styleFormLogin.css" rel="stylesheet">
    <link href="http://fonts.googleap.com/css?family=Crete+Round" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>EcoRide</title>
</head>

<header>
    <?php require_once '../script/scriptHeader.php'; ?>
</header>

<body>

    <?php require_once "../front/bigTitle.php"; ?>

    <h2>Formulaire d'inscription</h2>

    <form class="formLogin mx-auto" action="../script/registerVehiculePost.php" method="POST">

        <input type="hidden" name="proprietaire" value="<?php echo $proprietaireIdHidden ?>">

        <label class="label" for="marque">Marque : </label><br>
        <select class="inputBasic" name="marque">
            <option>--Choisissez une marque--</option>

            <?php 
            foreach ($marques as $marque): ?>
            <option value="<?php echo $marque['marque_id']; ?>">
                <?php echo ($marque['libelle']); ?>
            </option>
            <?php endforeach; ?>
        </select><br><br>

        <label class="label" for="modele">Modèle : </label><br>
        <input class="inputBasic" type="text" name="modele" required><br><br>

        <label class="label" for="immat">Immatriculation : </label><br>
        <input class="inputBasic" type="text" name="immat" required><br><br>

        <label class="label" for="premiereimmat">Date de première immatriculation : </label><br>
        <input class="inputBasic" type="date" name="premiereimmat" required><br><br>

        <label class="label" for="energie">Energie : </label><br>
        <select class="inputBasic" name="energie">
            <option>--Choisissez une énergie--</option>

            <?php 
            foreach ($energies as $energie): ?>
            <option value="<?php echo $energie['energie_id']; ?>">
                <?php echo ($energie['libelle']); ?>
            </option>
            <?php endforeach; ?>
        </select><br><br>

        <label class="label" for="couleur">Couleur : </label><br>
        <input class="inputBasic" type="text" name="couleur" required><br><br>

        <input class="button" type="submit" value="Créer">

    </form>
</body>