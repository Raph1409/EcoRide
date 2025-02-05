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

        // Mettre à jour le statut du covoiturage
        $sqlUpdate = "UPDATE covoiturage SET statut = ? WHERE covoiturage_id = ?";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute([$nouveauStatut, $id]);

        // Rediriger vers utilisateur.php UNIQUEMENT si le statut était 1
        header("Location: ../utilisateur.php");
        exit();
    } 
    
    elseif ($statutActuel == 3) {
        // Vérifier que tous les passagers ont noté le chauffeur
        $sqlCountIns = "SELECT COUNT(*) FROM inscription WHERE covoiturage_id = ?";
        $stmtCountIns = $pdo->prepare($sqlCountIns);
        $stmtCountIns->execute([$id]);
        $nbPassagers = $stmtCountIns->fetchColumn();

        $sqlCountNotes = "SELECT COUNT(DISTINCT passager_id) FROM notes WHERE covoiturage_id = ?";
        $stmtCountNotes = $pdo->prepare($sqlCountNotes);
        $stmtCountNotes->execute([$id]);
        $nbNotes = $stmtCountNotes->fetchColumn();

        if ($nbNotes == $nbPassagers && $nbPassagers > 0) {
            $nouveauStatut = 4;
        } else {
            $nouveauStatut = $statutActuel;
        }
    } 
    
    elseif ($statutActuel == 4) {
        // Changer le statut en 2 et rediriger vers employe.php
        $nouveauStatut = 2;

        // Mettre à jour le statut
        $sqlUpdate = "UPDATE covoiturage SET statut = ? WHERE covoiturage_id = ?";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute([$nouveauStatut, $id]);

        // Rediriger vers employe.php après mise à jour
        header("Location: ../employe.php");
        exit();
    } else {
        $nouveauStatut = $statutActuel;
    }

    // Mettre à jour le statut si nécessaire (pour les autres cas)
    if ($nouveauStatut != $statutActuel) {
        $sqlUpdate = "UPDATE covoiturage SET statut = ? WHERE covoiturage_id = ?";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute([$nouveauStatut, $id]);
    }
}
?>