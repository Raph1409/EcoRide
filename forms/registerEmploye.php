<body>

    <form class="formLogin mx-auto" action="/script/registerPostEmploye.php" method="POST">

        <input type="hidden" name="photo" value="E">

        <label class="label" for="pseudo">Pseudo : </label>
        <input class="inputBasic" type="text" name="pseudo" required><br><br>

        <label class="label" for="email">Adresse email : </label>
        <input class="inputBasic" type="email" name="email" required><br><br>

        <label class="label" for="password">Password : </label>
        <input class="inputBasic" type="password" name="password" required><br><br>

        <label class="label" for="name">Nom : </label>
        <input class="inputBasic" type="text" name="name" required><br><br>

        <label class="label" for="surname">Prénom : </label>
        <input class="inputBasic" type="text" name="surname" required><br><br>

        <label class="label" for="naissance">Date de Naissance : </label>
        <input class="inputBasic" type="date" name="naissance" required><br><br>

        <label class="label" for="choix">Choisissez un sexe :</label><br>
        <select class="inputBasic" id="choix" name="choix">
            <option value="">Sélectionner</option>
            <option value="H">Homme</option>
            <option value="F">Femme</option>
        </select><br><br>

        <label class="label" for="phone">Numéro de téléphone : </label>
        <input class="inputBasic" type="text" name="phone" required><br><br>

        <input class="button" type="submit" value="Créer">

    </form>
</body>