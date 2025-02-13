<?php 
session_start(); ?>

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
    <link href="/style/styleCovoiturage.css" rel="stylesheet">
    <link href="/style/styleIndex.css" rel="stylesheet">
    <link href="http://fonts.googleap.com/css?family=Crete+Round" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>EcoRide</title>

</head>

<header>
    <?php require_once '../script/scriptHeader.php'; ?>
    <?php require_once "../front/bigTitle.php"; ?>
</header>

<?php require_once '../script/connexionBDD.php';

// Vérifiez si l'utilisateur est connecté et s'il a un rôle
if (!isset($_SESSION["user"]) || ($_SESSION["user"]["role"] != 3 && $_SESSION["user"]["role"] != 1 && $_SESSION["user"]["role"] != 2)) {
    // Si l'utilisateur n'est pas connecté ou n'a pas de rôle, affichage d'un message
    echo '<div class="bienvenue mx-auto">' . " <p style='color:#EBF2FA; padding-top:20px; font-weight:bold;'>" .  "Vous devez être connecté pour créer à un covoiturage." . "</p>" . "<a style='color:#63340B; padding-top:20px; font-weight:bold;' href='../forms/login.php';> Connexion/Inscription </a>" . "<br>" . "<a style='color:#63340B;  font-weight:bold;' href='../index.php';> Retour </a>" . "</div>";
    exit;
}

// Récupération de l'ID de l'utilisateur connecté
$queryUtilisateur = "SELECT utilisateur_id FROM utilisateurs WHERE pseudo = :pseudo";
$stmt = $pdo->prepare($queryUtilisateur);
$stmt->bindParam(":pseudo", $_SESSION["user"]["pseudo"]);
$stmt->execute();

$createur = $stmt->fetch(PDO::FETCH_ASSOC);
$createurIdHidden = $createur['utilisateur_id'];

// Vérification du nombre de véhicules de l'utilisateur
$queryVoitures = "
    SELECT v.voiture_id, v.modele, m.libelle AS marque
    FROM voitures v
    JOIN marques m ON v.marque = m.marque_id
    WHERE v.proprietaire_id = :proprietaire_id
";
$stmt = $pdo->prepare($queryVoitures);
$stmt->execute(['proprietaire_id' => $createurIdHidden]);
$voitures = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Si aucun véhicule n'est trouvé, afficher un message
if (count($voitures) === 0) {
    echo '<div class="bienvenue mx-auto">' . " <p style='color:#EBF2FA; padding-top:20px; font-weight:bold;'>" .  "Vous devez enregistrer un véhicule pour pouvoir créer un covoiturage en tant que chauffeur." . "</p><br>" . "<a class='btn'; style='color:#63340B;  font-weight:bold;' href='../forms/vehiculeForm.php';> Ajouter un véhicule </a>" . "<a class='btn'; style='color:#63340B;  font-weight:bold;' href='../utilisateur.php';> Retour </a>" . "</div>";
    exit(); // Stopper l'exécution du reste du script
}
?>


<body>

    <h2>Formulaire d'inscription</h2>

    <form class="formLogin mx-auto" action="../script/registerCovoituragePost.php" method="POST">
        <input type="hidden" name="createur" value="<?php echo $createurIdHidden; ?>">

        <label class="label" for="ville_depart">Ville de départ</label><br>
        <input class="inputBasic" type="text" name="ville_depart" required><br><br>

        <label class="label" for="ville_arrivee">Ville d'arrivée </label><br>
        <input class="inputBasic" type="text" name="ville_arrivee" required><br><br>

        <label class="label" for="date_depart">Date de départ : </label><br>
        <input class="inputBasic" type="date" name="date_depart" required><br><br>

        <label class="label" for="date_arrivee">Date d'arrivée : </label><br>
        <input class="inputBasic" type="date" name="date_arrivee" required><br><br>

        <label class="label" for="heure_depart">Heure de départ : </label><br>
        <input class="inputBasic" type="time" name="heure_depart" required><br><br>

        <label class="label" for="heure_arrivee">Heure d'arrivée </label><br>
        <input class="inputBasic" type="time" name="heure_arrivee" required><br><br>

        <label class="label" for="prix">Prix par personne (crédits) : </label><br>
        <p style="font-size: 14px; font-style: italic; color: #EBF2FA;">La plateforme perçoit 2 crédits par passager
            afin de garantir son bon fonctionnement.</p>
        <input class="inputBasic" type="text" name="prix" required><br><br>

        <label class="label" for="nombre_place">Nombre de places : </label><br>
        <select class="inputBasic" name="nombre_place">
            <option>--Choisissez un nombre de place--</option>
            <?php for ($i = 1; $i <= 6; $i++): ?>
            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php endfor; ?>
        </select><br><br>

        <label class="label" for="trajet_eco">Trajet écologique : </label><br>
        <select class="inputBasic" name="trajet_eco">
            <option>--Choisissez une option--</option>
            <option value="oui">Oui</option>
            <option value="non">Non</option>
        </select><br><br>

        <label class="label" for="vehicule">Véhicule : </label><br>
        <select class="inputBasic" name="vehicule">
            <option>--Choisissez un véhicule--</option>
            <?php foreach ($voitures as $voiture): ?>
            <option value="<?php echo $voiture['voiture_id']; ?>">
                <?php echo htmlspecialchars($voiture['marque']) . " " . htmlspecialchars($voiture['modele']); ?>
            </option>
            <?php endforeach; ?>
        </select><br><br>

        <input class="button" type="submit" value="Créer">
    </form>

</body>

</html>

<footer>
    <?php require_once "../front/footer.php";?>
</footer>