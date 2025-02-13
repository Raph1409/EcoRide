<?php 

// définition du chemin absolu
$rootPath = dirname(__DIR__) . '/';



if (!isset($_SESSION["user"]['role'])) {
    $_SESSION['user']['role'] = '0';
}

 $utilisateur = $_SESSION ["user"]["role"];


if ($utilisateur == 1){
    require_once $rootPath . "front/headerAdmin.php";
} 

if ($utilisateur == 2){
    require_once $rootPath . "front/headerEmploye.php";
}

if ($utilisateur == 3){
    require_once $rootPath . "front/headerUtilisateur.php";
}

if ($utilisateur == 4){
    require_once $rootPath . "front/headerSuspendu.php";
}

if ($utilisateur == 0){
    require_once $rootPath . "front/header.php";
}

?>