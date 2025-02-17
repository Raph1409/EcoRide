<body>

    <form class="formLogin2 mx-auto" action="/script/registerPostEmploye.php" method="POST">

        <input type="hidden" name="photo" value="E">

        <label class="label" for="pseudo">Pseudo : </label><br>
        <input class="inputBasic2" type="text" name="pseudo" required><br><br>

        <label class="label" for="email">email : </label><br>
        <input class="inputBasic2" type="email" name="email" required><br><br>

        <label class="label" for="password">Password : </label><br>
        <input class="inputBasic2" type="password" name="password" required><br><br>

        <label class="label" for="name">Nom : </label><br>
        <input class="inputBasic2" type="text" name="name" required><br><br>

        <label class="label" for="surname">Prénom : </label><br>
        <input class="inputBasic2" type="text" name="surname" required><br><br>

        <label class="label" for="naissance">Né(e) le : </label><br>
        <input class="inputBasic2" type="date" name="naissance" required><br><br>

        <label class="label" for="choix">sexe :</label><br>
        <select class="inputBasic2" id="choix" name="choix">
            <option value="">Sélectionner</option>
            <option value="H">Homme</option>
            <option value="F">Femme</option>
        </select><br><br>

        <label class="label" for="phone">téléphone : </label><br>
        <input class="inputBasic2" type="text" name="phone" required><br><br>

        <input class="button" type="submit" value="Créer">

    </form>
</body>