<?php

 session_start();

 require_once '../script/connexionBDD.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["user"]["pseudo"])) {
    die("Erreur : utilisateur non connecté.");
    
}

if (isset($_GET['id'])) {
    $covoiturage_id = $_GET['id'];
} else {
    // Gérer le cas où l'ID est absent (ex: rediriger ou afficher une erreur)
    die("Covoiturage ID manquant !");
}


// Récupération de l'ID de l'utilisateur connecté
$queryChauffeur = "SELECT utilisateur FROM covoiturage WHERE covoiturage_id = :id";
$stmt = $pdo->prepare($queryChauffeur);
$stmt->bindParam(":id", $covoiturage_id);
$stmt->execute();

$chauffeur = $stmt->fetch(PDO::FETCH_ASSOC);
$chauffeurIdHidden = $chauffeur['utilisateur'];


// Récupération de l'ID de l'utilisateur connecté
$queryPassager = "SELECT utilisateur_id FROM utilisateurs WHERE pseudo = :pseudo";
$stmt = $pdo->prepare($queryPassager);
$stmt->bindParam(":pseudo", $_SESSION["user"]["pseudo"]);
$stmt->execute();

$passager = $stmt->fetch(PDO::FETCH_ASSOC);
$passagerIdHidden = $passager['utilisateur_id'];
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

    <?php require_once "../script/scriptHeader.php"; ?>

</header>

<body>

    <?php require_once "../front/bigTitle.php"; ?>

    <h2>Notez votre covoiturage !</h2>

    <form class="formLogin mx-auto" id="noteForm" action="../script/notePost.php" method="POST">
        <!-- Données cachées -->
        <input type="hidden" name="covoiturage_id" value="<?php echo $covoiturage_id; ?>">
        <input type="hidden" name="chauffeur_id" value="<?php echo $chauffeurIdHidden; ?>">
        <input type="hidden" name="passager_id" value="<?php echo $passagerIdHidden; ?>">

        <!-- Note -->
        <label class="label" for="note">Notez votre covoiturage sur 5 : </label><br><br>
        <select class="inputBasic" name="note" required>
            <option value="">--Choisissez votre note--</option>
            <?php for ($i = 1; $i <= 5; $i++): ?>
            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php endfor; ?>
        </select><br><br>

        <!-- Commentaire -->
        <label for="commentaire" class="label">Écrivez votre commentaire :</label> <br><br>
        <textarea name="commentaire" class="inputBasic" rows="5" cols="50" required></textarea> <br><br>

        <!-- Bouton -->
        <button type="button" class="btn btn-primary" onclick="submitForms()">Envoyer</button>
    </form>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        console.log("✅ Script chargé !");

        window.submitForms = function() {
            console.log("➡ Envoi AJAX vers ../script/statutsSwitch.php...");

            // Données à envoyer
            let formData = new FormData();
            formData.append('id', '<?= htmlspecialchars($covoiturage_id) ?>');
            formData.append('statut', '4');

            // Envoi AJAX vers statutsSwitch.php
            fetch('../script/statutsSwitch.php', { // Correction du nom du fichier
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text()) // Récupérer la réponse
                .then(data => {
                    console.log("✅ Réponse de statutsSwitch.php :", data);

                    if (data.includes("success")) { // Si le statut est bien mis à jour
                        console.log("📨 Envoi du formulaire noteForm...");
                        document.getElementById('noteForm').submit(); // Soumettre le formulaire
                    } else {
                        console.error("❌ Erreur dans statutsSwitch.php :", data);
                        alert("Erreur lors du changement de statut !");
                    }
                })
                .catch(error => {
                    console.error("❌ Erreur AJAX :", error);
                    alert("Erreur de communication avec le serveur.");
                });
        };
    });
    </script>


</body>