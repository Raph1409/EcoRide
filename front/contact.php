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
    <link href="/style/styleFormLogin.css" rel="stylesheet">
    <link href="http://fonts.googleap.com/css?family=Crete+Round" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>EcoRide</title>
</head>

<header>

    <?php require_once "../script/scriptHeader.php"; ?>

</header>

<body>

    <?php require_once "../front/bigTitle.php"; ?>

    <h2>Contact</h2>

    <form class="formLogin mx-auto" action="loginPost.php" method="POST">

        <label for="email" class="label">Votre mail :</label> <br><br>
        <input type="email" name="email" class="inputBasic" required> <br><br>

        <label for="titre" class="label">Titre :</label> <br><br>
        <input type="text" name="password" class="inputBasic" required> <br><br>

        <label for="Description" class="label">Description :</label> <br><br>
        <textarea name="password" class="inputBasic" rows="10" cols="50" required></textarea> <br><br>

        <input class="bouton" type="submit" value="Envoyer">
    </form>

</body>

<footer>

    <?php require_once "../front/footer.php";?>

</footer>