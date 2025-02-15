<?php session_start();
    
    require_once '../script/connexionBDD.php';

    // Vérifier que l'utilisateur est connecté
    if (!isset($_SESSION["user"]["pseudo"])) {
    die("Erreur : utilisateur non connecté.");
    }

    // Récupérer l'ID du covoiturage depuis l'URL
    if (isset($_GET['id'])) {
        $covoiturage_id = $_GET['id'];
    } else {
    die("Covoiturage ID manquant !");
    }

        // Récupérer l'ID du chauffeur depuis la table covoiturage
        $queryChauffeur = "SELECT utilisateur FROM covoiturage WHERE covoiturage_id = :id";
        $stmt = $pdo->prepare($queryChauffeur);
        $stmt->bindParam(":id", $covoiturage_id, PDO::PARAM_INT);
        $stmt->execute();
        $chauffeur = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$chauffeur) {
    die("Covoiturage non trouvé.");
    }
    
    $chauffeurIdHidden = $chauffeur['utilisateur'];

        // Récupérer l'ID du passager depuis la table utilisateurs (via le pseudo stocké en session)
        $queryPassager = "SELECT utilisateur_id FROM utilisateurs WHERE pseudo = :pseudo";
        $stmt = $pdo->prepare($queryPassager);
        $stmt->bindParam(":pseudo", $_SESSION["user"]["pseudo"]);
        $stmt->execute();
        $passager = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$passager) {
    die("Utilisateur non trouvé.");
    }

    $passagerIdHidden = $passager['utilisateur_id'];
?>


<head>
    <meta charset="utf-8">
    <title>Notez votre covoiturage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/style/styleFormLogin.css" rel="stylesheet">
    <link href="/style/styleCovoiturage.css" rel="stylesheet">
    <link href="/style/styleIndex.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php require_once '../script/scriptHeader.php'; ?>
    <?php require_once '../front/bigTitle.php'; ?>

    <div class="container mt-5">
        <h2 class="mb-4">Notez votre covoiturage !</h2>
        <form class="formLogin mx-auto" id="noteForm">

            <input type="hidden" name="covoiturage_id" value="<?php echo htmlspecialchars($covoiturage_id); ?>">
            <input type="hidden" name="chauffeur_id" value="<?php echo htmlspecialchars($chauffeurIdHidden); ?>">
            <input type="hidden" name="passager_id" value="<?php echo htmlspecialchars($passagerIdHidden); ?>">

            <div class="mb-3">
                <label for="note" class="label">Notez votre covoiturage sur 5 :</label>
                <select class="inputBasic" name="note" id="note" required>
                    <option value="">--Choisissez votre note--</option>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="commentaire" class="label">Écrivez votre commentaire :</label>
                <textarea class="inputBasic" name="commentaire" id="commentaire" rows="5" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
    </div>

    <?php require_once '../front/footer.php'; ?>


    <script>
    document.getElementById('noteForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        // Envoi vers notePost.php
        fetch('../script/notePost.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === 'success') {
                    window.location.href = '../script/confirmation2.php';
                } else {
                    alert("Une erreur est survenue : " + data);
                }
            })
            .catch(error => {
                console.error("Erreur AJAX : ", error);
                alert("Erreur lors de l'envoi de la note.");
            });
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>