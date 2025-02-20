<?php 
session_start();
require_once '../script/connexionBDD.php';
?>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <meta charset="utf_8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/style/styleHeader.css" rel="stylesheet">
    <link href="/style/styleBigTitle.css" rel="stylesheet">
    <link href="/style/styleFooter.css" rel="stylesheet">
    <link href="/style/styleMessageLogin.css" rel="stylesheet">
    <link href="http://fonts.googleap.com/css?family=Crete+Round" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<header>
    <?php require_once '../front/header.php'; ?>
</header>

<body>
    <?php require_once '../front/bigTitle.php'; ?>

    <h2>Connexion</h2>

    <?php
    // Récupérer les données du formulaire de connexion
    $emailForm = $_POST['email'];
    $passwordForm = $_POST['password'];

    $query = "SELECT * FROM utilisateurs WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $emailForm);
    $stmt->execute();

    // Vérification de l'existence de l'utilisateur
    if ($stmt->rowCount() == 1) {
        $monUtilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (password_verify($passwordForm, $monUtilisateur["password"])) {
            // Stockage des informations de l'utilisateur en session
            $_SESSION["user"] = [
                "pseudo" => $monUtilisateur["pseudo"],
                "email" => $monUtilisateur["email"],
                "role" => $monUtilisateur["role"],
                "nom" => $monUtilisateur["nom"],
                "prenom" => $monUtilisateur["prenom"],
            ];

            // Redirection en fonction du rôle
            if ($_SESSION["user"]["role"] === 1) {
                header("Location: ../admin.php");
                exit();
            } else if ($_SESSION["user"]["role"] === 2) {
                header("Location: ../index.php");
                exit();
            } else if ($_SESSION["user"]["role"] === 4) {
                header("Location: ../script/suspendu.php");    
                exit();
            } else if ($_SESSION["user"]["role"] === 3) {
                header("Location: ../index.php");
                exit();
            }
        } else {
            require_once "../script/wrongLogin.php";
        }
    } else {
        // Message si l'email n'existe pas
        require_once "../script/wrongLogin.php";
    }
    ?>
</body>