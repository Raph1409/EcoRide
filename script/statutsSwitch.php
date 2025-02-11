<?php
require '../script/connexionBDD.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

        // Récupérer le statut actuel, le prix et le conducteur du covoiturage
        $sqlGetStatus = "SELECT statut, prix_personne, utilisateur FROM covoiturage WHERE covoiturage_id = ?";
        $stmtGetStatus = $pdo->prepare($sqlGetStatus);
        $stmtGetStatus->execute([$id]);
        $covoiturage = $stmtGetStatus->fetch(PDO::FETCH_ASSOC);
    
    if ($covoiturage) {
        $statutActuel = $covoiturage['statut'];
        $prixPersonne = floatval($covoiturage['prix_personne']);
        $conducteurPseudo = $covoiturage['utilisateur'];
    } else {
        exit("Covoiturage introuvable");
    }

        // Récupérer le pseudo du conducteur à partir de son ID
        $sqlGetPseudo = "SELECT pseudo FROM utilisateurs WHERE utilisateur_id = ?";
        $stmtGetPseudo = $pdo->prepare($sqlGetPseudo);
        $stmtGetPseudo->execute([$conducteurPseudo]);
        $conducteurPseudo = $stmtGetPseudo->fetchColumn();


    if ($statutActuel == 1) {
        // Vérifier s'il y a des inscriptions pour ce covoiturage
        $sqlCheck = "SELECT COUNT(*) FROM inscription WHERE covoiturage_id = ?";
        $stmtCheck = $pdo->prepare($sqlCheck);
        $stmtCheck->execute([$id]);
        $nbInscriptions = $stmtCheck->fetchColumn();

        $nouveauStatut = ($nbInscriptions > 0) ? 3 : 2;

        // Mettre à jour le statut
        $sqlUpdate = "UPDATE covoiturage SET statut = ? WHERE covoiturage_id = ?";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute([$nouveauStatut, $id]);

        header("Location: ../utilisateur.php");
        exit();
    } elseif ($statutActuel == 3) {
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
    } elseif ($statutActuel == 4) {
        // Débiter chaque passager et créditer le conducteur
        $sqlPassagers = "SELECT utilisateur_pseudo FROM inscription WHERE covoiturage_id = ?";
        $stmtPassagers = $pdo->prepare($sqlPassagers);
        $stmtPassagers->execute([$id]);
        $passagers = $stmtPassagers->fetchAll(PDO::FETCH_COLUMN);
        
        $nbPassagers = count($passagers);
        
        foreach ($passagers as $passagerPseudo) {
            // Débiter le passager
            $sqlDebit = "UPDATE utilisateurs SET credit = credit - ? WHERE pseudo = ?";
            $stmtDebit = $pdo->prepare($sqlDebit);
            $stmtDebit->execute([$prixPersonne, $passagerPseudo]);
        }

        // Créditer le conducteur
        if ($nbPassagers > 0) {
            $totalRevenu = ($prixPersonne * $nbPassagers) - (2 * $nbPassagers);
            $sqlCreditConducteur = "UPDATE utilisateurs SET credit = credit + ? WHERE pseudo = ?";
            $stmtCreditConducteur = $pdo->prepare($sqlCreditConducteur);
            $stmtCreditConducteur->execute([$totalRevenu, $conducteurPseudo]);
        }

        // Créditer l'admin
        if ($nbPassagers > 0) {
            $totalAdmin = 2 * $nbPassagers;
            $sqlCreditAdmin = "UPDATE utilisateurs SET credit = credit + ? WHERE role = 1";
            $stmtCreditAdmin = $pdo->prepare($sqlCreditAdmin);
            $stmtCreditAdmin->execute([$totalAdmin]);
        }

        // Changer le statut en 2 et rediriger vers employe.php
        $nouveauStatut = 2;
        $sqlUpdate = "UPDATE covoiturage SET statut = ? WHERE covoiturage_id = ?";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute([$nouveauStatut, $id]);

        header("Location: ../employe.php");
        exit();
    } else {
        $nouveauStatut = $statutActuel;
    }

    // Mettre à jour le statut si nécessaire
    if ($nouveauStatut != $statutActuel) {
        $sqlUpdate = "UPDATE covoiturage SET statut = ? WHERE covoiturage_id = ?";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute([$nouveauStatut, $id]);
    }
}
?>