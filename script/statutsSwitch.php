<?php
require '../script/connexionBDD.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Récupérer le statut actuel du covoiturage
    $sqlGetStatus = "SELECT statut FROM covoiturage WHERE covoiturage_id = ?";
    $stmtGetStatus = $pdo->prepare($sqlGetStatus);
    $stmtGetStatus->execute([$id]);
    $statutActuel = $stmtGetStatus->fetchColumn();

    if ($statutActuel == 1) {
        // Vérifier s'il y a des inscriptions pour ce covoiturage
        $sqlCheck = "SELECT COUNT(*) FROM inscription WHERE covoiturage_id = ?";
        $stmtCheck = $pdo->prepare($sqlCheck);
        $stmtCheck->execute([$id]);
        $nbInscriptions = $stmtCheck->fetchColumn();

        // Déterminer le nouveau statut
        $nouveauStatut = ($nbInscriptions > 0) ? 3 : 2;
    } elseif ($statutActuel == 3) {
        // Si le statut est 3, on passe simplement à 4
        $nouveauStatut = 4;
    } 
    
     elseif ($statutActuel == 4) {
        // Si le statut est  4, on passe simplement à 2
        $nouveauStatut = 2;
    }else {
        echo "Le statut du covoiturage ne peut pas être mis à jour.";
        exit();
    }

    // Mettre à jour le statut du covoiturage
    $sqlUpdate = "UPDATE covoiturage SET statut = ? WHERE covoiturage_id = ?";
    $stmtUpdate = $pdo->prepare($sqlUpdate);

    if ($stmtUpdate->execute([$nouveauStatut, $id])) {
        // Redirection après mise à jour
        header("Location: ../utilisateur.php?success=statutUpdated");
        exit();
    } else {
        echo "Erreur lors de la mise à jour du statut.";
    }
} else {
    echo "Requête invalide.";
}