<form action="./newUser.php" method="post">
	
    <div class="formbutton">Création d'un compte</div> 

    <div>
        <label for="name">Nom :</label>
        <input autofocus type="text" id="name" name="name" required>
    </div>
    <div>
        <label for="firstname">Prénom :</label>
        <input autofocus type="text" id="firstname" name="firstname" required>
    </div>
    <div>
        <label for="email">Email :</label>
        <input autofocus type="email" id="email" name="email" required>
    </div>
    <div>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div>
        <label for="confirm">Confirmer mot de passe :</label>
        <input type="password" id="confirm" name="confirm" required>
    </div>
    <div>
        <label for="birth">Date de naissance</label>
        <input autofocus type="date" id="birth" name="birth" required>
    </div>
    <div>
        <label for="adresse">Adresse :</label>
        <input type="text" id="adresse" name="adresse" required><br>

        <label for="codepostal">Code postal :</label>
        <input type="text" id="codepostal" name="codepostal" required><br>

        <label for="commune">Commune :</label>
        <input type="text" id="commune" name="commune" required><br>
    </div>
    <div class="formbutton">
        <button type="submit">Créer le compte</button>
    </div>
</form>