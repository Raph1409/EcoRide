<?php
$url = getenv('JAWSDB_URL');

if ($url) {
    // Environnement Heroku (JawsDB)
    $dbparts = parse_url($url);
    
    $hostname = $dbparts['host'];
    $username = $dbparts['user'];
    $password = $dbparts['pass'];
    $database = ltrim($dbparts['path'], '/');
    $port = 3306;
} else {
    // Environnement local
    $hostname = "127.0.0.1";
    $username = "root";
    $password = "";
    $database = "ecoride";
    $port = 3307;
}

// Connexion à la base de données avec PDO
try {
    $pdo = new PDO("mysql:host=$hostname;port=$port;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>