<?php session_start(); ?>

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
    <link href="/style/styleHeader.css" rel="stylesheet">
    <link href="/style/styleBigTitle.css" rel="stylesheet">
    <link href="/style/styleFooter.css" rel="stylesheet">
    <link href="/style/styleMessageLogin.css" rel="stylesheet">
    <link href="http://fonts.googleap.com/css?family=Crete+Round" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<header>
    <?php require_once '../script/scriptHeader.php'; ?>
</header>

<body>

    <?php 
    require_once '../front/bigTitle.php'; 
    require_once '../script/connexionBDD.php';
    ?>

    <?php

//Récupérer les données du formulaire de création de compte
$covoiturageForm = $_POST['covoiturage_id'];
$chauffeurForm = $_POST['chauffeur_id'];
$noteForm = $_POST['note'];
$commentaireForm = $_POST['commentaire'];
$passagerForm = $_POST['passager_id'];

var_dump($covoiturageForm);
var_dump($chauffeurForm);
var_dump($noteForm);
var_dump($commentaireForm);
var_dump($passagerForm);

// Insérer les données dans la base
$insertQuery = "INSERT INTO notes (note, commentaire, chauffeur_id, covoiturage_id, passager_id)
                VALUES (:note, :commentaire, :chauffeur_id, :covoiturage_id, :passager_id)";
$stmt = $pdo->prepare($insertQuery);
$stmt->bindParam(":note", $noteForm);
$stmt->bindParam(":commentaire", $commentaireForm);
$stmt->bindParam(":chauffeur_id", $chauffeurForm);
$stmt->bindParam(":covoiturage_id", $covoiturageForm);
$stmt->bindParam(":passager_id", $passagerForm);
$stmt->execute();

echo '<div class="bienvenue mx-auto">' . " <p style='color:#EBF2FA; padding-top:20px; font-weight:bold;'>" . "Merci d'avoir noté votre chauffeur !" ."</p>" . "<a style='color:#63340B; padding-top:20px; font-weight:bold;' href='../utilisateur.php';> Retour </a>" . "</div>" ; 


?>

    <footer>
        <?php require_once '../front/footer.php'; ?>
    </footer>