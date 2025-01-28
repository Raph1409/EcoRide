<?php

    require_once 'script/connexionBDD.php';

    $queryCompte = "SELECT pseudo, email 
                 FROM utilisateurs";
    $stmt = $pdo->prepare($queryCompte);
    $stmt->execute();
    $comptes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<form action="forms/modifCompteForm.php" class="formLogin2 mx-auto" method="POST">

    <label class="label" for="compte">Compte :</label><br>
    <select class="inputBasic2" name="compte" id="compte-select">
        <option value="">--Choisissez un compte--</option>
        <?php
    foreach($comptes as $compte){
        echo '<option value="' . htmlspecialchars($compte['pseudo']) . '">'
         . htmlspecialchars($compte['pseudo']) . ' (' . htmlspecialchars($compte['email']) . ')</option>';
    }?>
    </select><br><br>
    <input class="button" type="submit" value="Choisir">
</form>