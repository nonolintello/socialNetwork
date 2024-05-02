<form action="./newUser.php" method="post" enctype="multipart/form-data"> 
    <div class="form-group">
        <label for="name">Nom :</label>
        <input type="text" id="name" name="name" class="form-control" required autofocus>
    </div>
    <div class="form-group">
        <label for="firstname">Prénom :</label>
        <input type="text" id="firstname" name="firstname" class="form-control" required>
    </div>
    
    <div class="form-group">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" class="form-control" required>
    </div>
    
    <div class="form-group">
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" class="form-control" required>
    </div>
    
    <div class="form-group">
        <label for="confirm">Confirmer le mot de passe :</label>
        <input type="password" id="confirm" name="confirm" class="form-control" required>
    </div>
    
    <div class="form-group">
        <label for="birth">Date de naissance :</label>
        <input type="date" id="birth" name="birth" class="form-control" required>
    </div>
    
    <div class="form-group">
        <label for="adresse">Adresse :</label>
        <input type="text" id="adresse" name="adresse" class="form-control" required>
    </div>
    
    <div class="form-group">
        <label for="codepostal">Code postal :</label>
        <input type="text" id="codepostal" name="codepostal" class="form-control" required>
    </div>
    
    <div class="form-group">
        <label for="commune">Commune :</label>
        <input type="text" id="commune" name="commune" class="form-control" required>
    </div>
    
    <div class="form-group">
        <label for="avatar">Avatar :</label>
        <input type="file" id="avatar" name="avatar" class="form-control">
    </div>
    
    <div class="form-group mt-3">
        <button type="submit" class="btn btn-primary">Créer le compte</button>
    </div>
</form>
