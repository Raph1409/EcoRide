<?php

// Connexion à la base de données
require_once '../script/connexionBDD.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $userId = $_POST['compte']; // L'ID de l'utilisateur à créditer
    $amount = $_POST['amount']; // Le montant à créditer

    // Vérifier si le montant est valide
    if ($amount <= 0) {
        echo "Le montant doit être positif.";
        exit();
    }

    // Mettre à jour le solde de l'utilisateur
    $query = "UPDATE utilisateurs SET credit = credit + ? WHERE utilisateur_id = ? AND role = 3";
    $stmt = $pdo->prepare($query);

    // Lier les paramètres et exécuter la requête
    $stmt->execute([$amount, $userId]);

    // Vérifier si la requête a réussi
    if ($stmt->rowCount() > 0) {
        // Rediriger vers la page admin.php
        header("Location: ../admin.php");
        exit();
    } else {
        echo "Erreur lors du crédit de l'utilisateur.";
    }
}

?>