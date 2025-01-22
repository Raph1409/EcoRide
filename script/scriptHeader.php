<?php 

if (!isset($_SESSION["user"]['role'])) {
    $_SESSION['user']['role'] = '0';
}

 $utilisateur = $_SESSION ["user"]["role"];


if ($utilisateur == 1){
    require_once "front/headerAdmin.php";
} 

if ($utilisateur == 2){
    require_once "front/headerEmploye.php";
}

if ($utilisateur == 3){
    require_once "front/headerUtilisateur.php";
}

if ($utilisateur == 0){
    require_once "../front/header.php";
}

?>