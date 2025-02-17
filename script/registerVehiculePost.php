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

    //Récupérer les données du formulaire de création de compte
    $marqueForm = $_POST['marque'];
    $modeleForm = $_POST['modele'];
    $couleurForm = $_POST['couleur'];
    $immatForm = $_POST['immat'];
    $premiereImmatForm = $_POST['premiereimmat'];
    $energieForm = $_POST['energie'];
    $proprioForm = $_POST['proprietaire'];

    //Vérification de l'immatriculation (unique)
    $query = "SELECT * FROM voitures WHERE immatriculation = :immatriculation";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":immatriculation", $immatForm);
    $stmt->execute();

    //Est-ce que l'immatriculation existe
    if($stmt->rowCount() > 0){
    echo '<div class="bienvenue mx-auto">' . " <p style='color:#EBF2FA; padding-top:20px; font-weight:bold;'>" . "Cette immatriculation est déjà utilisée" ."</p>" . "<a style='color:#63340B; padding-top:20px; font-weight:bold;' href='../utilisateur.php';> Retour </a>" . "</div>";
    die();
    
}

    //Insérer les données dans la base
    $insertQuery = "INSERT INTO voitures (modele, immatriculation, couleur, date_premiere_immat, marque, energie, proprietaire_id) 
                    VALUES (:modele, :immatriculation, :couleur, :date_premiere_immat, :marque, :energie, :proprietaire_id)";
    $stmt2 = $pdo->prepare($insertQuery);
    $stmt2->bindParam(":modele", $modeleForm);
    $stmt2->bindParam(":immatriculation", $immatForm);
    $stmt2->bindParam(":couleur", $couleurForm);
    $stmt2->bindParam(":date_premiere_immat", $premiereImmatForm);
    $stmt2->bindParam(":marque", $marqueForm);
    $stmt2->bindParam(":energie", $energieForm);
    $stmt2->bindParam(":proprietaire_id", $proprioForm);
    $stmt2->execute();

        echo '<div class="bienvenue mx-auto">' . " <p style='color:#EBF2FA; padding-top:20px; font-weight:bold;'>" . "Création de véhicule réussie !" ."</p>" . "<a style='color:#63340B; padding-top:20px; font-weight:bold;' href='../utilisateur.php';> Retour </a>" . "</div>" ; 


?>