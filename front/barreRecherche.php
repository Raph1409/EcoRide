<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/style/styleBarreRecherche.css" rel="stylesheet">
    <title>Formulaire de Recherche</title>
</head>

<body>
    <!-- Formulaire -->
    <div class="container-fluid py-2">
        <h4>Rechercher un trajet</h4>
        <form class="row g-3" action="../script/resultats.php" method="POST">
            <!-- Champ Ville de départ -->
            <div class="col-md-3">
                <label for="ville" class="form-label text-white">Ville de départ</label>
                <input type="text" name="villedepart" class="form-control" id="ville"
                    placeholder="Entrez la ville de départ">
            </div>

            <!-- Champ Ville d'arrivé -->
            <div class="col-md-3">
                <label for="ville" class="form-label text-white">Ville d'arrivé</label>
                <input type="text" name="villearrivee" class="form-control" id="ville"
                    placeholder="Entrez la ville d'arrivé">
            </div>

            <!-- Champ Date de départ -->
            <div class="col-md-3">
                <label for="date-depart" class="form-label text-white">Date de départ</label>
                <input type="date" name="datedepart" class="form-control" id="date-depart">
            </div>

            <!-- Bouton Rechercher -->
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="w-100">Rechercher</button>
            </div>
        </form>
    </div>
</body>

</html>