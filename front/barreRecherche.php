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
        <h4 class="text-center">Rechercher un trajet</h4>
        <form class="row g-3 justify-content-center" action="../script/resultats.php" method="POST">
            <!-- Champ Ville de départ -->
            <div class="col-md-2">
                <label for="villedepart" class="form-label text-white">Ville de départ</label>
                <input type="text" name="villedepart" class="form-control" id="villedepart"
                    placeholder="Entrez la ville de départ">
            </div>

            <!-- Champ Ville d'arrivée -->
            <div class="col-md-2">
                <label for="villearrivee" class="form-label text-white">Ville d'arrivée</label>
                <input type="text" name="villearrivee" class="form-control" id="villearrivee"
                    placeholder="Entrez la ville d'arrivée">
            </div>

            <!-- Champ Date de départ -->
            <div class="col-md-2">
                <label for="date-depart" class="form-label text-white">Date de départ</label>
                <input type="date" name="datedepart" class="form-control" id="date-depart">
            </div>

            <!-- Bouton Rechercher -->
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn-custom w-100">Rechercher</button>
            </div>

            <!-- Bouton Créer un covoiturage -->
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn-custom w-100"
                    onclick="window.location.href='../forms/covoiturageForm.php'">
                    Créer un Covoiturage
                </button>
            </div>
        </form>
    </div>
</body>

</html>