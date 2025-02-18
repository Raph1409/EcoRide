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
    <?php require_once '../front/header.php'; ?>
</header>

<body>

    <?php 
    require_once '../front/bigTitle.php'; 
    require_once '../script/connexionBDD.php';

    //Récupérer les données du formulaire de création de compte
    $pseudoForm = $_POST['pseudo'];
    $emailForm = $_POST['email'];
    $passwordForm = $_POST['password'];
    $nameForm = $_POST['name'];
    $surnameForm = $_POST['surname'];
    $birthdayForm = $_POST['naissance'];
    $phoneForm = $_POST['phone'];
    $sexeForm = $_POST['choix'];

    // crédit bonus pour inscription et parametrage du rôle utilisateur par défault

    $roleDefault = 2;
    $creditDefault = 0;


    //Vérification de l'adresse mail (unique)
    $query = "SELECT * FROM utilisateurs WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $emailForm);
    $stmt->execute();
    if($stmt->rowCount() > 0){
        echo '<div class="bienvenue mx-auto">' . " <p style='color:#EBF2FA; padding-top:20px; font-weight:bold;'>" . "Cette adresse mail est déjà utilisée" ."</p>" . "<a style='color:#63340B; padding-top:20px; font-weight:bold;' href='../admin.php';> Retour </a>" . "</div>";
        die();
        
    }

    //Hashage du mot de passe
    $hashedPassword = password_hash($passwordForm, PASSWORD_DEFAULT);

    // Déterminer l'image à insérer en fonction du choix
    if ($sexeForm == "H") {
            $photoContent = file_get_contents('../images/employe.png');
    } elseif ($sexeForm == "F") {
            $photoContent = file_get_contents('../images/employeF.png');
    }

    //Insérer les données dans la base
    $insertQuery = "INSERT INTO utilisateurs (pseudo, email, password, nom, prenom, date_naissance, telephone, role, photo, credit) VALUES (:pseudo, :email, :password, :name, :surname, :birthday, :phone, :role, :photo, :credit)";
    $stmt = $pdo->prepare($insertQuery);
    $stmt->bindParam(":pseudo", $pseudoForm);
    $stmt->bindParam(":email", $emailForm);
    $stmt->bindParam(":password", $hashedPassword);
    $stmt->bindParam(":name", $nameForm);
    $stmt->bindParam(":surname", $surnameForm);
    $stmt->bindParam(":birthday", $birthdayForm);
    $stmt->bindParam(":phone", $phoneForm);
    $stmt->bindParam(":role", $roleDefault);
    $stmt->bindParam(":photo", $photoContent, PDO::PARAM_LOB);
    $stmt->bindParam(":credit", $creditDefault);
    $stmt->execute();
    echo '<div class="bienvenue mx-auto">' . " <p style='color:#EBF2FA; padding-top:20px; font-weight:bold;'>" . "Création de compte employé(e) réussie !" ."</p>" . "<a style='color:#63340B; padding-top:20px; font-weight:bold;' href='../index.php';> Retour </a>" . "</div>" ; 


?>