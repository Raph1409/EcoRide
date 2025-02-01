<?php 

require_once 'connexionBDD.php';

$user_id = $_SESSION['user']['pseudo'];

$query = "
    SELECT nom, prenom, email, telephone, adresse, date_naissance, photo, pseudo, credit 
    FROM utilisateurs 
    WHERE pseudo = :user_id
";

// Préparer et exécuter la requête SQL
$stmt = $pdo->prepare($query);
$stmt->execute([':user_id' => $user_id]);

// Récupérer les données
$mesInfos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si des informations ont été récupérées
if (!empty($mesInfos)) {
    $user = $mesInfos[0]; // On suppose qu'il n'y a qu'un seul utilisateur
?>
<div class="body mt-5 mx-auto">
    <!-- Informations de l'utilisateur -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card-header text-center">
                <h4>Mes Informations</h4>
            </div>
            <div class="card-body">
                <!-- Affichage de la photo de profil -->
                <div class="text-center">
                    <img src="data:image/jpeg;base64,<?= base64_encode($user['photo']) ?>" alt="Photo de profil"
                        class="rounded-circle" width="150" height="150">
                </div>
                <h5 class="mt-3 text-center"><?= htmlspecialchars($user['prenom']) ?>
                    <?= htmlspecialchars($user['nom']) ?></h5>
                <p class="text-center"><strong>Pseudo:</strong> <?= htmlspecialchars($user['pseudo']) ?></p>

                <!-- Informations personnelles -->
                <div>
                    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                    <p><strong>Téléphone:</strong> <?= htmlspecialchars($user['telephone']) ?></p>
                    <p><strong>Adresse:</strong> <?= htmlspecialchars($user['adresse']) ?></p>
                    <p><strong>Date de naissance:</strong> <?= htmlspecialchars($user['date_naissance']) ?></p>
                    <p><strong>Crédits:</strong> <?= htmlspecialchars($user['credit']) ?> Crédits</p>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="modifier_profil.php" class="btn btn-warning">Modifier mes informations</a>
            </div>
        </div>
    </div>
</div>
<?php
} else {
    echo "<p>Aucune information disponible.</p>";
}
?>