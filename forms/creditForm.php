<?php

// Connexion à la base de données
require_once 'script/connexionBDD.php';

// Récupérer les utilisateurs avec le rôle 3
$queryCompte = "SELECT utilisateur_id, pseudo, email 
                FROM utilisateurs
                WHERE role = 3";
$stmt = $pdo->prepare($queryCompte);
$stmt->execute();
$comptes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<form action="../script/creditFormPost.php" class="formLogin2 mx-auto w-50" method="POST">

    <label class="label" for="compte">Compte :</label><br>
    <select class="inputBasic2" name="compte" id="compte-select">
        <option value="">--Choisissez un compte--</option>
        <?php
        foreach($comptes as $compte){
            echo '<option value="' . htmlspecialchars($compte['utilisateur_id']) . '">'
                . htmlspecialchars($compte['pseudo']) . ' (' . htmlspecialchars($compte['email']) . ')</option>';
        }
        ?>
    </select><br><br>

    <label class="label" for="amount">Montant à créditer :</label><br>
    <input class="inputBasic2" type="number" name="amount" id="amount" required><br><br>

    <input class="button" type="submit" value="Créditer">
</form>