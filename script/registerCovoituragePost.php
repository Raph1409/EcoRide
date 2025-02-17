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
        $villeDepartForm = $_POST['ville_depart'];
        $villeArriveeForm = $_POST['ville_arrivee'];
        $heureDepartForm = $_POST['heure_depart'];
        $heureArriveeForm = $_POST['heure_arrivee'];
        $dateDepartForm = $_POST['date_depart'];
        $dateArriveeForm = $_POST['date_arrivee'];
        $prixForm = $_POST['prix'];
        $nbPlaceForm = $_POST['nombre_place'];
        $ecologieForm = $_POST['trajet_eco'];
        $véhiculeForm = $_POST['vehicule'];
        $createurId = $_POST['createur'];
        $statut = 1;

        //Insérer les données dans la base
        $insertQuery = "INSERT INTO covoiturage (date_depart, heure_depart, lieu_depart, date_arrive, heure_arrive, lieu_arrive, nb_place, prix_personne, statut, voiture, utilisateur, ecologique) 
                        VALUES (:date_depart, :heure_depart, :lieu_depart, :date_arrive, :heure_arrive, :lieu_arrive, :nb_place, :prix_personne, :statut, :voiture, :utilisateur, :ecologique)";
        $stmt = $pdo->prepare($insertQuery);
        $stmt->bindParam(":date_depart", $dateDepartForm);
        $stmt->bindParam(":heure_depart", $heureDepartForm);
        $stmt->bindParam(":lieu_depart", $villeDepartForm);
        $stmt->bindParam(":date_arrive", $dateArriveeForm);
        $stmt->bindParam(":heure_arrive", $heureArriveeForm);
        $stmt->bindParam(":lieu_arrive", $villeArriveeForm);
        $stmt->bindParam(":nb_place", $nbPlaceForm);
        $stmt->bindParam(":prix_personne", $prixForm);
        $stmt->bindParam(":statut", $statut);
        $stmt->bindParam(":voiture", $véhiculeForm);
        $stmt->bindParam(":utilisateur", $createurId);
        $stmt->bindParam(":ecologique", $ecologieForm);
        $stmt->execute();

        echo '<div class="bienvenue mx-auto">' . " <p style='color:#EBF2FA; padding-top:20px; font-weight:bold;'>" . "Création de covoiturage réussie !" ."</p>" . "<a style='color:#63340B; padding-top:20px; font-weight:bold;' href='../utilisateur.php';> Retour </a>" . "</div>" ; 


?>