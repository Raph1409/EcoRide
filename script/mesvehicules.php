<?php 

require_once 'connexionBDD.php';

$user_id = $_SESSION['user']['pseudo'];

$query = "
    SELECT 
        v.modele,
        v.immatriculation,
        v.couleur,
        v.date_premiere_immat,
        m.libelle AS marque,
        e.libelle AS energie
    FROM 
        voitures v
    JOIN 
        marques m ON v.marque = m.marque_id
    JOIN 
        energies e ON v.energie = e.energie_id
    JOIN 
        utilisateurs u ON u.voiture = v.voiture_id  -- Jointure avec la table utilisateurs via la colonne 'voiture'
    WHERE 
        u.pseudo = :user_id
";

// Préparer et exécuter la requête SQL
$stmt = $pdo->prepare($query);
$stmt->execute([':user_id' => $user_id]);

// Récupérer les données
$mesVehicules = $stmt->fetchAll(PDO::FETCH_ASSOC); 
?>

<h2 class="h2statut mx-auto">Mes véhicules</h2>

<?php

if (!empty($mesVehicules)) {
    // Parcours des véhicules (si un utilisateur peut avoir plusieurs véhicules)
    foreach ($mesVehicules as $vehicule) {
?>
<div class="body mt-5 mx-auto">
    <!-- Informations du véhicule -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card-body">
                <!-- Affichage des informations du véhicule -->
                <div class="text-center">
                    <p><strong>Marque:</strong> <?= htmlspecialchars($vehicule['marque']) ?></p>
                    <p><strong>Modèle:</strong> <?= htmlspecialchars($vehicule['modele']) ?></p>
                    <p class="text-center"><strong>Immatriculation:</strong>
                        <?= htmlspecialchars($vehicule['immatriculation']) ?></p>
                    <div>
                        <p><strong>Couleur:</strong> <?= htmlspecialchars($vehicule['couleur']) ?></p>
                        <p><strong>Date de Première Immatriculation:</strong>
                            <?= htmlspecialchars($vehicule['date_premiere_immat']) ?></p>
                        <p><strong>Énergie:</strong> <?= htmlspecialchars($vehicule['energie']) ?></p>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <!-- Bouton de modification des informations du véhicule -->
                <a href="modifier_vehicule.php" class="btn btn-warning">Modifier mon véhicule</a>
            </div>
        </div>
    </div>
</div>
<?php
    }
} else {
    echo "<p>Aucun véhicule trouvé pour cet utilisateur.</p>";
}
?>

<!-- Bouton "Ajouter un véhicule" toujours visible sous la carte utilisateur -->
<div class="text-center mt-4">
    <a href="ajouter_vehicule.php" class="btn btn-success">Ajouter un véhicule</a>
</div>