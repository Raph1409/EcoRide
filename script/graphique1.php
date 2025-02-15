<?php
    require_once 'connexionBDD.php';

    header("Content-Type: image/png");

    // Récupération des données
    $sql = "SELECT DATE(date_depart) AS jour, COUNT(*) AS nb_covoiturages 
            FROM covoiturage 
            GROUP BY jour 
            ORDER BY jour ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $jours = array_column($data, 'jour');
    $valeurs = array_column($data, 'nb_covoiturages');

    // Paramètres
    $largeur = 400;
    $hauteur = 300;
    $marge_gauche = 50;
    $marge_bas = 50;
    $espacement_barres = 40;
    $largeur_barre = 30;

    // Création de l'image
    $image = imagecreatetruecolor($largeur, $hauteur);
    $blanc = imagecolorallocate($image, 255, 255, 255);
    $noir = imagecolorallocate($image, 0, 0, 0);
    $bleu = imagecolorallocate($image, 66, 122, 161); // Couleur #427AA1
    $vert = imagecolorallocate($image, 103, 148, 54); // Couleur #679436

    imagefill($image, 0, 0, $blanc);

    // Axes
    imageline($image, $marge_gauche, $hauteur - $marge_bas, $largeur - 10, $hauteur - $marge_bas, $noir);
    imageline($image, $marge_gauche, 10, $marge_gauche, $hauteur - $marge_bas, $noir);

    // Dessin du graphique
    $max_valeur = max($valeurs);
    foreach ($jours as $i => $jour) {
        $x = $marge_gauche + ($i * $espacement_barres);
        $hauteur_barre = ($valeurs[$i] / $max_valeur) * ($hauteur - $marge_bas - 20);
        $y = $hauteur - $marge_bas - $hauteur_barre;

        imagefilledrectangle($image, $x, $y, $x + $largeur_barre, $hauteur - $marge_bas, $bleu);
        imagestring($image, 3, $x + 5, $y - 20, $valeurs[$i], $vert);
        imagestringup($image, 3, $x + 10, $hauteur - $marge_bas + 40, $jour, $vert);
    }

    // Envoi au navigateur
    imagepng($image);
    imagedestroy($image);
?>