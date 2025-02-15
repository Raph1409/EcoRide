<?php
    require_once 'connexionBDD.php';

    // Récupérer le total des crédits gagnés par la plateforme
    $sql = "SELECT SUM(credit) AS total_credits FROM utilisateurs WHERE role = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    $totalCredits = $data['total_credits'];

    // Affichage du compteur
        echo '<div class="compteur">';
        echo '<h2 style="margin: auto 20px; text-decoration: underline;">Nombre de crédits gagnés par la plateforme :</h2>';
        echo '<input type="text" style="color: #427AA1; font-size: 30px; text-align: center; margin-bottom: 10px;" value="' . number_format($totalCredits, 0, ',', ' ') . '" readonly>';
        echo '</div>';
?>