<?php
require_once '../script/connexionBDD.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifiez si le formulaire a été correctement soumis
    if (isset($_POST['nouveau_role']) && isset($_POST['pseudo'])) {
        $nouveauRoleId = $_POST['nouveau_role'];
        $pseudo = $_POST['pseudo'];

        // Mettre à jour le rôle dans la base de données
        $updateQuery = "UPDATE utilisateurs SET role = :role WHERE pseudo = :pseudo";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->bindParam(':role', $nouveauRoleId, PDO::PARAM_INT);
        $updateStmt->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);

        if ($updateStmt->execute()) {
            // Redirigez avec un message de succès
            header("Location: ../script/confirmation.php?success=1&pseudo=" . urlencode($pseudo));
            exit;
        } else {
            // Redirigez avec un message d'erreur
            header("Location: ../script/confirmation.php?success=0");
            exit;
        }
    }
}