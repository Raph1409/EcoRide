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

    <form class="formLogin mx-auto" action="/script/registerPost.php" method="POST">

        <label class="label" for="pseudo">Pseudo : </label><br>
        <input class="inputBasic" type="text" name="pseudo" required><br><br>

        <label class="label" for="email">Adresse email : </label><br>
        <input class="inputBasic" type="email" name="email" required><br><br>

        <label class="label" for="password">Password : </label><br>
        <input class="inputBasic" type="password" name="password" required><br><br>

        <label class="label" for="name">Nom : </label><br>
        <input class="inputBasic" type="text" name="name" required><br><br>

        <label class="label" for="surname">Prénom : </label><br>
        <input class="inputBasic" type="text" name="surname" required><br><br>

        <label class="label" for="naissance">Date de Naissance : </label><br>
        <input class="inputBasic" type="date" name="naissance" required><br><br>

        <label class="label" for="phone">Numéro de téléphone : </label><br>
        <input class="inputBasic" type="text" name="phone" required><br><br>

        <input class="button" type="submit" value="Créer">

    </form>
</body>