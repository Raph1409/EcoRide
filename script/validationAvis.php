<?php 
    require_once 'connexionBDD.php';

    $user_id = $_SESSION['user']['pseudo'];

    // Récupération des covoiturages avec leurs passagers et commentaires groupés
    $query = "
        SELECT 
            c.covoiturage_id,
            c.utilisateur AS createur_id,
            u1.pseudo AS createur_pseudo,
            u1.email AS createur_email,
            u1.telephone AS createur_telephone,
            s.libelle AS statut_nom,
            GROUP_CONCAT(u2.pseudo SEPARATOR '|') AS passager_pseudo,
            GROUP_CONCAT(u2.email SEPARATOR '|') AS passager_email,
            GROUP_CONCAT(u2.telephone SEPARATOR '|') AS passager_telephone,
            GROUP_CONCAT(n.commentaire SEPARATOR '|') AS commentaire,
            COUNT(n.passager_id) AS total_votes,
            (SELECT COUNT(*) FROM inscription i WHERE i.covoiturage_id = c.covoiturage_id) AS total_passagers
        FROM covoiturage c
        JOIN statuts s ON c.statut = s.statut_id
        JOIN utilisateurs u1 ON c.utilisateur = u1.utilisateur_id  
        LEFT JOIN notes n ON c.covoiturage_id = n.covoiturage_id
        LEFT JOIN utilisateurs u2 ON n.passager_id = u2.utilisateur_id
        WHERE s.statut_id IN (4, 2)
        GROUP BY c.covoiturage_id
        ORDER BY c.date_depart DESC
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $covoiturages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $a_valider = [];
    $termine = [];

    foreach ($covoiturages as $covoiturage) {
        if ($covoiturage['statut_nom'] == 'A Valider') {
            $a_valider[] = $covoiturage;
        } else {
            $termine[] = $covoiturage;
        }
    }
?>

<h2>Mes covoiturages (Chauffeur)</h2><br>

<h2 class="h2statut mx-auto">A Valider</h2><br>
<div class="container">
    <div class="row mx-auto" style="width: 100%;">
        <?php foreach ($a_valider as $covoiturage): ?>
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <p><strong>ID Covoiturage :</strong> <?= htmlspecialchars($covoiturage['covoiturage_id']) ?></p>
                    <p><strong>Créateur :</strong> <?= htmlspecialchars($covoiturage['createur_pseudo']) ?> <br>
                        <strong>Email :</strong> <?= htmlspecialchars($covoiturage['createur_email']) ?> <br>
                        <strong>Téléphone :</strong> <?= htmlspecialchars($covoiturage['createur_telephone']) ?>
                    </p>
                    <?php 
                    $passagers = explode('|', $covoiturage['passager_pseudo']);
                    $emails = explode('|', $covoiturage['passager_email']);
                    $telephones = explode('|', $covoiturage['passager_telephone']);
                    $commentaires = explode('|', $covoiturage['commentaire']);
                    foreach ($passagers as $index => $passager): ?>
                    <p><strong>Passager :</strong> <?= htmlspecialchars($passager) ?> <br>
                        <strong>Email :</strong> <?= htmlspecialchars($emails[$index]) ?> <br>
                        <strong>Téléphone :</strong> <?= htmlspecialchars($telephones[$index]) ?>
                    </p>
                    <p><strong>Commentaire :</strong> <?= htmlspecialchars($commentaires[$index]) ?></p>
                    <?php endforeach; ?>
                </div>
                <?php if ($covoiturage['total_votes'] == $covoiturage['total_passagers']): ?>
                <div class="card-footer text-center d-flex gap-2 justify-content-center align-items-center">
                    <form method="post" action="../script/statutsSwitch.php">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($covoiturage['covoiturage_id']) ?>">
                        <button type="submit" class="btn btn-success">Valider</button>
                    </form>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<h2 class="h2statut mx-auto">Terminé</h2><br>
<div class="container">
    <div class="row mx-auto" style="width: 100%;">
        <?php foreach ($termine as $covoiturage): ?>
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <p><strong>ID Covoiturage :</strong> <?= htmlspecialchars($covoiturage['covoiturage_id']) ?></p>
                    <p><strong>Créateur :</strong> <?= htmlspecialchars($covoiturage['createur_pseudo']) ?> <br>
                        <strong>Email :</strong> <?= htmlspecialchars($covoiturage['createur_email']) ?> <br>
                        <strong>Téléphone :</strong> <?= htmlspecialchars($covoiturage['createur_telephone']) ?>
                    </p>
                    <?php 
                    $passagers = explode('|', $covoiturage['passager_pseudo']);
                    $emails = explode('|', $covoiturage['passager_email']);
                    $telephones = explode('|', $covoiturage['passager_telephone']);
                    $commentaires = explode('|', $covoiturage['commentaire']);

                    foreach ($passagers as $index => $passager): ?>
                    <p><strong>Passager :</strong> <?= htmlspecialchars($passager) ?> <br>
                        <strong>Email :</strong> <?= htmlspecialchars($emails[$index]) ?> <br>
                        <strong>Téléphone :</strong> <?= htmlspecialchars($telephones[$index]) ?>
                    </p>
                    <p><strong>Commentaire :</strong> <?= htmlspecialchars($commentaires[$index]) ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>