<?php 

    require_once 'connexionBDD.php';

    $user_id = $_SESSION['user']['pseudo'];

    // Récupération des covoiturages en fonction du statut
    $query = "
        SELECT 
            c.covoiturage_id,
            c.date_depart,
            c.date_arrive,
            c.lieu_depart,
            c.lieu_arrive,
            c.heure_depart,
            c.heure_arrive,
            c.nb_place,
            c.ecologique,
            c.prix_personne,
            s.libelle AS statut_nom,  
            u.pseudo,                
            u.photo                  
        FROM covoiturage c
        JOIN statuts s ON c.statut = s.statut_id
        JOIN utilisateurs u ON c.utilisateur = u.utilisateur_id  
        WHERE c.utilisateur = (SELECT utilisateur_id FROM utilisateurs WHERE pseudo = :user_id)
        ORDER BY c.date_depart DESC
    ";



    $stmt = $pdo->prepare($query);
    $stmt->execute([':user_id' => $user_id]);

    $covoiturages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Tableau pour stocker les covoiturages par statut
    $en_cours = [];
    $en_attente = [];
    $termine = [];
    $a_valider = [];

    // Parcourir les résultats et trier par statut
    foreach ($covoiturages as $covoiturage) {
        switch ($covoiturage['statut_nom']) {
            case 'En cours':
                $en_cours[] = $covoiturage;
            break;
            case 'En attente':
                $en_attente[] = $covoiturage;
            break;
            case 'Terminer':
                $termine[] = $covoiturage;
            break;
            case 'A Valider':
                $a_valider[] = $covoiturage;
            break;
        }
    }
?>

<h2>Mes covoiturages (Chauffeur)</h2><br>
<h2 class="h2statut mx-auto">En Cours</h2><br>
<div class="container">
    <div class="row mx-auto" style="width: 100%;">
        <?php foreach ($en_cours as $covoiturage): ?>
        <div class="col-12 col-md-6 col-lg-4 md-4">
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
                <div class="card-footer text-center d-flex gap-2 justify-content-center align-items-center">
                    <form method="post" action="../script/deleteCovoiturage.php">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($covoiturage['covoiturage_id']) ?>">
                        <button type="submit" class="btn btn-danger">Annulé</button>
                    </form>
                    <form method="post" action="../script/statutsSwitch.php">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($covoiturage['covoiturage_id']) ?>">
                        <button type="submit" name="statut" value="3" class="btn btn-warning">Arrivé</button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>


<h2 class="h2statut mx-auto">En attente de notation</h2><br>
<div class="container">
    <div class="row mx-auto" style="width: 100%;">
        <?php foreach ($en_attente as $covoiturage): ?>
        <div class="col-12 col-md-6 col-lg-4 mb-4">
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
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<h2 class="h2statut mx-auto">En attente de validation</h2><br>
<div class="container">

    <div class="row mx-auto" style="width: 100%;">
        <?php foreach ($a_valider as $covoiturage): ?>
        <div class="col-12 col-md-6 col-lg-4 md-4">
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
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<h2 class="h2statut mx-auto">Terminé</h2><br>
<div class="container">

    <div class="row mx-auto" style="width: 100%;">
        <?php foreach ($termine as $covoiturage): ?>
        <div class="col-12 col-md-6 col-lg-4 mb-4">
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
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="text-center mt-4">
    <a href="../forms/covoiturageForm.php" class="btn btn-success">Créer un Covoiturage</a>
</div><br>
</body>