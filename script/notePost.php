<?php session_start();

    require_once '../script/connexionBDD.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Vérifier que tous les paramètres nécessaires sont présents
        if (!isset($_POST['covoiturage_id'], $_POST['chauffeur_id'], $_POST['note'], $_POST['commentaire'], $_POST['passager_id'])) {
            echo "Paramètres manquants.";
        exit();
        }

        $covoiturageForm = $_POST['covoiturage_id'];
        $chauffeurForm   = $_POST['chauffeur_id'];
        $noteForm        = $_POST['note'];
        $commentaireForm = $_POST['commentaire'];
        $passagerForm    = $_POST['passager_id'];

        // Insérer la note dans la base de données
        $insertQuery = "INSERT INTO notes (note, commentaire, chauffeur_id, covoiturage_id, passager_id)
                        VALUES (:note, :commentaire, :chauffeur_id, :covoiturage_id, :passager_id)";
        $stmt = $pdo->prepare($insertQuery);
        $stmt->bindParam(":note", $noteForm);
        $stmt->bindParam(":commentaire", $commentaireForm);
        $stmt->bindParam(":chauffeur_id", $chauffeurForm);
        $stmt->bindParam(":covoiturage_id", $covoiturageForm);
        $stmt->bindParam(":passager_id", $passagerForm);

    if ($stmt->execute()) {
        // Mettre à jour le statut du covoiturage
        $_POST['id'] = $covoiturageForm;
        require '../script/statutsSwitch.php';
            echo "success";
        exit();
    } else {
        echo "Erreur lors de l'enregistrement de la note.";
    }
    } else {
        echo "Requête invalide.";
    exit();
    }
?>