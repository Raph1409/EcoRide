<?php
    require 'connexionBDD.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
        $id = $_POST['id'];

    // Requête pour supprimer le covoiturage
    $sql = "DELETE FROM covoiturage WHERE covoiturage_id = ?";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$id])) {
        header("Location: ../utilisateur.php?success=deleted");
        exit();
    } else {
        echo "Erreur lors de la suppression.";
    }
    } else {
    echo "Requête invalide.";
    }
?>