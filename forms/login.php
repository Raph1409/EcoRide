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

    <h2>Connexion</h2>

    <form class="formLogin mx-auto" action="../script/loginPost.php" method="POST">
        <!-- EMAIL -->
        <label for="email" class="label">Adresse e-mail :</label>
        <input type="email" name="email" class="inputBasic2" required> <br><br>
        <!-- PASSWORD -->
        <label for="password" class="label">Mot de passe :</label>
        <input type="password" name="password" class="inputBasic2" required> <br><br>
        <!-- BUTTON -->
        <input class="bouton" type="submit" value="Se connecter"><br><br>
        <a href="/">Créer un compte</a>
    </form>
</body>


</html>