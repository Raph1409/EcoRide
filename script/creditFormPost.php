<?php
    require_once '../script/connexionBDD.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userId = $_POST['compte'];
        $amount = $_POST['amount'];

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
        header("Location: ../admin.php");
        exit();
    } else {
        echo "Erreur lors du crédit de l'utilisateur.";
    }
    }

?>