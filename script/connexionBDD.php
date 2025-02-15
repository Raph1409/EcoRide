<?php
    $dsn = "mysql:host=127.0.0.1;port=3307;dbname=ecoride;";
    $username = "user_php";
    $password = "4g8rkkEmn4JH89P"; 

    try{
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    
    }catch(PDOException $e) {
        echo "Erreur De connexion à la base de données : ". $e->getMessage();
    }   
    
?>