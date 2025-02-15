<?php session_start();
    require_once 'connexionBDD.php';

    // L'utilisateur est-il connecté
    if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
    }

    // Vérifier que l'ID du covoiturage est bien passé en paramètre
    if (isset($_GET['id'])) {
        $covoiturage_id = $_GET['id'];
        $user_id = $_SESSION['user']['pseudo'];

    try {
        // Démarrer une transaction pour garantir que les deux actions se passent ensemble
        $pdo->beginTransaction();

        // Supprimer l'inscription dans la table inscription
        $stmt = $pdo->prepare("DELETE FROM inscription WHERE covoiturage_id = :covoiturage_id AND utilisateur_pseudo = :user_id");
        $stmt->execute([
            ':covoiturage_id' => $covoiturage_id,
            ':user_id' => $user_id
        ]);

        // Recréditer une place dans la table covoiturage
        $stmt = $pdo->prepare("UPDATE covoiturage SET nb_place = nb_place + 1 WHERE covoiturage_id = :covoiturage_id");
        $stmt->execute([
            ':covoiturage_id' => $covoiturage_id
        ]);

        // Valider la transaction
        $pdo->commit();

        // Rediriger l'utilisateur
        header('Location: ../utilisateur.php');
        exit;

    } catch (PDOException $e) {
        // Annuler la transaction en cas d'erreur
        $pdo->rollBack();
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "L'ID du covoiturage est manquant.";
}
?>