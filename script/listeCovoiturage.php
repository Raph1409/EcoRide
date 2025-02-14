<head>
    <link href="/style/styleCovoiturage.css" rel="stylesheet">
</head>

<?php
// Connexion à la base de données
require_once 'connexionBDD.php'; 

// Récupération des covoiturages disponibles avec les infos de l'utilisateur et de leur moyenne de notes
$query = $pdo->query("
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
        (SELECT ROUND(AVG(n.note), 1) 
         FROM notes n 
         WHERE n.chauffeur_id = u.utilisateur_id) AS moyenne_note
    FROM covoiturage c
    JOIN utilisateurs u ON c.utilisateur = u.utilisateur_id
    WHERE c.statut = 1
    ORDER BY c.date_depart ASC, c.heure_depart ASC
");

$covoiturages = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<body>

    <h2 class="mb-4">Covoiturages Disponibles</h2>

    <div class="row mx-auto" style="width: 80%;">
        <?php foreach ($covoiturages as $index => $covoiturage): ?>
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-body d-flex">
                    <!-- Colonne gauche : Profil -->
                    <div class="text-center me-3">
                        <img src="data:image/jpeg;base64,<?= base64_encode($covoiturage['photo']) ?>"
                            alt="Photo de profil" class="rounded-circle" width="80" height="80">

                        <h6 class="pseudoCard mt-2"><?= htmlspecialchars($covoiturage['pseudo']) ?></h6>

                        <!-- Affichage de la note moyenne bien espacée -->
                        <p class="text-warning">
                            <?php
    $note = $covoiturage['moyenne_note'];
    if ($note !== null) {
        $noteInt = floor($note);
        $demiEtoile = fmod($note, 1) >= 0.5;
        
        // Affichage des étoiles pleines
        for ($i = 0; $i < $noteInt; $i++) {
            echo "⭐";
        }

        // Affichage d'une demi-étoile si nécessaire
        if ($demiEtoile) {
            echo "⭐️½";
        }

        // Compléter avec des étoiles vides si nécessaire
        for ($i = $noteInt + $demiEtoile; $i < 5; $i++) {
            echo "☆";
        }
    } else {
        echo "Non noté";
    }
    ?>
                        </p>
                    </div>

                    <!-- Colonne droite : Infos covoiturage -->
                    <div>
                        <p class="lieuCard"><?= htmlspecialchars($covoiturage['lieu_depart']) ?> ➝
                            <?= htmlspecialchars($covoiturage['lieu_arrive']) ?></p>
                        <p><span class="souligneCard"><strong>Départ :</strong></span><br>
                            <?= date('d/m/Y H:i', strtotime($covoiturage['date_depart'] . ' ' . $covoiturage['heure_depart'])) ?>
                        </p>
                        <p><span class="souligneCard"><strong>Arrivée :</strong></span><br>
                            <?= date('d/m/Y H:i', strtotime($covoiturage['date_arrive'] . ' ' . $covoiturage['heure_arrive'])) ?>
                        </p>
                        <p><span class="souligneCard"><strong>Places :</strong></span>
                            <?= htmlspecialchars($covoiturage['nb_place']) ?></p>
                        <p><span class="souligneCard"><strong>Écologique :</strong></span>
                            <?= htmlspecialchars($covoiturage['ecologique']) ?></p>
                        <p class="fw-bold"><?= number_format($covoiturage['prix_personne'], 2) ?> Crédits</p>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="../front/detailCovoiturage.php?id=<?= isset($covoiturage['covoiturage_id']) ? urlencode($covoiturage['covoiturage_id']) : '' ?>"
                        class="btn btn-primary">Détails</a>

                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

</body>

</html>