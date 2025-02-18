<?php session_start(); 

    require_once '../script/connexionBDD.php';


    if (isset($_GET['id'])) {
        $covoiturage_id = $_GET['id'];
    } else {
        echo "Covoiturage non trouvé";
    exit;
    }

    $query = $pdo->prepare("
        SELECT  
            c.date_depart, 
            c.date_arrive, 
            c.heure_depart, 
            c.heure_arrive, 
            c.lieu_depart, 
            c.lieu_arrive, 
            c.nb_place, 
            c.ecologique, 
            c.prix_personne,
            c.covoiturage_id, 
            u.utilisateur_id, 
            u.pseudo, 
            u.photo,
            v.modele, 
            v.couleur, 
            v.date_premiere_immat, 
            m.libelle AS marque,
            e.libelle AS energie,
            (SELECT ROUND(AVG(note), 1) FROM notes WHERE chauffeur_id = u.utilisateur_id) AS moyenne_note
        FROM covoiturage c
        JOIN utilisateurs u ON c.utilisateur = u.utilisateur_id
        JOIN voitures v ON c.voiture = v.voiture_id
        JOIN marques m ON v.marque = m.marque_id
        JOIN energies e ON v.energie = e.energie_id
        WHERE c.covoiturage_id = :covoiturage_id
    ");

    $query->bindParam(':covoiturage_id', $covoiturage_id, PDO::PARAM_INT);
    $query->execute();

    $covoiturage = $query->fetch(PDO::FETCH_ASSOC);

    if (!$covoiturage) {
        echo "Covoiturage introuvable";
    exit;
    }


    // Vérifiez si l'utilisateur est connecté et s'il a le bon rôle (id == 3)
    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role']) || $_SESSION['user']['role'] != 3) {
        // Si l'utilisateur n'est pas connecté ou n'a pas le rôle utilisateur, redirigez-le ou affichez un message
        echo require_once "../script/besoinConnexion.php";
    exit;
    }

    // Gérer l'inscription si l'utilisateur est connecté et a le bon rôle
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifiez que l'utilisateur a sélectionné un covoiturage et qu'il y a des places disponibles
    if ($covoiturage['nb_place'] > 0) {
        // Décrémentez le nombre de places disponibles
        $updateQuery = $pdo->prepare("UPDATE covoiturage SET nb_place = nb_place - 1 WHERE covoiturage_id = :covoiturage_id");
        $updateQuery->bindParam(':covoiturage_id', $covoiturage_id, PDO::PARAM_INT);
        $updateQuery->execute();

// Inscrire l'utilisateur dans la table d'inscriptions
    $insertQuery = $pdo->prepare("INSERT INTO inscription (covoiturage_id, utilisateur_pseudo) VALUES (:covoiturage_id, :utilisateur_pseudo)");
    $insertQuery->bindParam(':covoiturage_id', $covoiturage_id, PDO::PARAM_INT);
    $insertQuery->bindParam(':utilisateur_pseudo', $_SESSION['user']['pseudo'], PDO::PARAM_STR);
    $insertQuery->execute();        

        // Rediriger ou afficher un message de succès
        echo '<div class="bienvenue mx-auto">' . " <p style='color:#EBF2FA; padding-top:20px; font-weight:bold;'>" .  "Inscription réussie !" ."</p>" . "<a style='color:#EBF2FA; padding-top:20px; font-weight:bold;' href='../index.php';> Retour </a>" . "</div>";
    exit;
    } else {
        echo '<div class="bienvenue mx-auto">' . " <p style='color:#EBF2FA; padding-top:20px; font-weight:bold;'>" .   "Aucune place disponible." ."</p>" . "<a style='color:#EBF2FA; padding-top:20px; font-weight:bold;' href='../index.php';> Retour </a>" . "</div>";
    }
    }
?>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <link href="/style/styleIndex.css" rel="stylesheet">
    <link href="/style/styleCovoiturage.css" rel="stylesheet">
    <title>EcoRide</title>
</head>

<header>
    <?php require_once "../script/scriptHeader.php"; ?>
    <?php require_once "../front/bigTitle.php"; ?>
</header>

<body>

    <h2 class="mb-4 text-center">Détails du Covoiturage</h2>

    <div class="row mx-auto justify-content-center">
        <div class="col-12 col-md-8 col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-body d-flex flex-column align-items-center text-center">
                    <div class="me-3">
                        <img src="data:image/jpeg;base64,<?= base64_encode($covoiturage['photo']) ?>"
                            alt="Photo de profil" class="rounded-circle" width="80" height="80">
                        <h6 class="pseudoCard mt-2"><?= htmlspecialchars($covoiturage['pseudo']) ?></h6>
                        <p class="text-warning">
                            <?php
                                $note = $covoiturage['moyenne_note'];
                            if ($note !== null) {
                                $noteInt = floor($note);
                                $demiEtoile = fmod($note, 1) >= 0.5;
                            for ($i = 0; $i < $noteInt; $i++) {
                                echo "⭐";
                            }
                            if ($demiEtoile) {
                                echo "⭐️½";
                            }

                            for ($i = $noteInt + $demiEtoile; $i < 5; $i++) {
                                echo "☆";
                            }
                            } else {
                                echo "Non noté";
                            }
                            ?></p>
                    </div>

                    <div class="mt-3">
                        <p class="lieuCard"><?= htmlspecialchars($covoiturage['lieu_depart']) ?> ➝
                            <?= htmlspecialchars($covoiturage['lieu_arrive']) ?></p>
                        <p><span class="souligneCard"><strong>Départ :</strong></span>
                            <?= date('d/m/Y H:i', strtotime($covoiturage['date_depart'] . ' ' . $covoiturage['heure_depart'])) ?>
                        </p>
                        <p><span class="souligneCard"><strong>Arrivée :</strong></span>
                            <?= date('d/m/Y H:i', strtotime($covoiturage['date_arrive'] . ' ' . $covoiturage['heure_arrive'])) ?>
                        </p>
                        <p><span class="souligneCard"><strong>Places :</strong></span>
                            <?= htmlspecialchars($covoiturage['nb_place']) ?></p>
                        <p><span class="souligneCard"><strong>Écologique :</strong></span>
                            <?= htmlspecialchars($covoiturage['ecologique']) ?></p>
                        <p><span class="souligneCard"><strong>Prix :</strong></span>
                            <?= number_format($covoiturage['prix_personne'], 2) ?> Crédits</p>

                        <h5 class="lieuCard mt-4">Informations sur le Véhicule</h5><br>
                        <p><span class="souligneCard"><strong>Marque :</strong></span>
                            <?= htmlspecialchars($covoiturage['marque']) ?></p>
                        <p><span class="souligneCard"><strong>Modèle :</strong></span>
                            <?= htmlspecialchars($covoiturage['modele']) ?></p>
                        <p><span class="souligneCard"><strong>Couleur :</strong></span>
                            <?= htmlspecialchars($covoiturage['couleur']) ?></p>
                        <p><span class="souligneCard"><strong>Énergie :</strong></span>
                            <?= htmlspecialchars($covoiturage['energie']) ?></p>
                        <p><span class="souligneCard"><strong>Date de Première Immatriculation :</strong></span>
                            <?= date('d/m/Y', strtotime($covoiturage['date_premiere_immat'])) ?></p>
                    </div>
                </div>

                <div class="card-footer text-center">

                    <form method="POST">
                        <button type="submit" class="btn btn-success"
                            <?= $covoiturage['nb_place'] <= 0 ? 'disabled' : '' ?>>S'inscrire</button>
                    </form>
                    <?php if ($covoiturage['nb_place'] <= 0): ?>
                    <p class="mt-2 text-danger">Aucune place disponible</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</body>

<footer>
    <?php require_once "../front/footer.php";?>
</footer>