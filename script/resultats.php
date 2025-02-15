<?php session_start(); 

    require_once '../script/connexionBDD.php';

    // Récupération des données du formulaire
    $villeDepart = !empty($_POST['villedepart']) ? trim($_POST['villedepart']) : null;
    $villeArrivee = !empty($_POST['villearrivee']) ? trim($_POST['villearrivee']) : null;
    $dateDepart = !empty($_POST['datedepart']) ? trim($_POST['datedepart']) : null;

    $query = "
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
            u.photo
        FROM covoiturage c
        JOIN utilisateurs u ON c.utilisateur = u.utilisateur_id
        WHERE 1=1
    ";
    $params = [];

    if ($villeDepart) {
        $query .= " AND lieu_depart LIKE :depart";
        $params[':depart'] = "%$villeDepart%";
    }
    if ($villeArrivee) {
        $query .= " AND lieu_arrive LIKE :arrivee";
        $params[':arrivee'] = "%$villeArrivee%";
    }
    if ($dateDepart) {
        $query .= " AND date_depart = :date";
        $params[':date'] = $dateDepart;
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $covoiturages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<head>
    <meta charset="UTF-8">
    <link href="/style/styleCovoiturage.css" rel="stylesheet">
    <link href="/style/styleIndex.css" rel="stylesheet">
    <title>Résultats de recherche</title>
</head>

<header>

    <?php require_once "../script/scriptHeader.php"; ?>
    <?php require_once "../front/bigTitle.php"; ?>
    <?php require_once "../front/barreRecherche.php";?>

</header>

<body>
    <h2 class="mb-4">Covoiturages Disponibles</h2>
    <div class="row mx-auto" style="width: 75%;">
        <?php if (count($covoiturages) > 0): ?>
        <?php foreach ($covoiturages as $covoiturage): ?>
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-body d-flex">
                    <div class="text-center me-3">
                        <img src="data:image/jpeg;base64,<?= base64_encode($covoiturage['photo']) ?>"
                            alt="Photo de profil" class="rounded-circle" width="80" height="80">
                        <h6 class="pseudoCard mt-2"><?= htmlspecialchars($covoiturage['pseudo']) ?></h6>
                    </div>
                    <div>
                        <p class="lieuCard"><?= htmlspecialchars($covoiturage['lieu_depart']) ?> ➝
                            <?= htmlspecialchars($covoiturage['lieu_arrive']) ?></p>
                        <p><strong>Départ :</strong>
                            <?= date('d/m/Y H:i', strtotime($covoiturage['date_depart'] . ' ' . $covoiturage['heure_depart'])) ?>
                        </p>
                        <p><strong>Arrivée :</strong>
                            <?= date('d/m/Y H:i', strtotime($covoiturage['date_arrive'] . ' ' . $covoiturage['heure_arrive'])) ?>
                        </p>
                        <p><strong>Places :</strong> <?= htmlspecialchars($covoiturage['nb_place']) ?></p>
                        <p><strong>Écologique :</strong> <?= htmlspecialchars($covoiturage['ecologique']) ?></p>
                        <p class="fw-bold"><?= number_format($covoiturage['prix_personne'], 2) ?> Crédits</p>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="../front/detailCovoiturage.php?id=<?= urlencode($covoiturage['covoiturage_id']) ?>"
                        class="btn btn-primary">Détails</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <p>Aucun covoiturage trouvé.</p>
        <?php endif; ?>
    </div>
</body>

<footer>

    <?php require_once "../front/footer.php";?>

</footer>

</html>