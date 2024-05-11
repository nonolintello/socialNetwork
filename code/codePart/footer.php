<footer class="footer">
    © 2024 MonSite. Tous droits réservés.
    <a href="#" class="text-light">Contactez-nous</a> |
    <a href="#" class="text-light">Conditions d'utilisation</a>



</footer>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="script/javascript.js"></script>
<!-- WARNING -->
<div id="warningForm" style="display:none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1050; background: #fff; padding: 25px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 8px; width: 90%; max-width: 400px;">
    <textarea id="warningText" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; resize: none;" rows="4">Vous avez reçu un avertissement pour comportement inapproprié.</textarea>
    <button onclick="sendWarning(currentPostId, currentOwnerId)" style="width: 100%; padding: 10px; margin-top: 20px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">Envoyer l'avertissement</button>
</div>

<!-- SENSIBLE -->
<div id="sensibleForm" style="display:none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1050; background: #fff; padding: 25px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 8px; width: 90%; max-width: 400px;">
    <textarea id="sensibleText" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; resize: none;" rows="4">Votre message a été marqué comme sensible. Il sera bloqué sauf sur votre page de blog personnel.</textarea>
    <button onclick="sendSensible(currentPostId, currentOwnerId)" style="width: 100%; padding: 10px; margin-top: 20px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">Envoyer une notification</button>
</div>

<!-- REMOVED -->
<div id="removedForm" style="display:none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1050; background: #fff; padding: 25px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 8px; width: 90%; max-width: 400px;">
    <textarea id="removedText" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; resize: none;" rows="4">Votre message enfreint gravement les règles de la communauté et sera supprimé. Il ne sera visible sur aucune interface sur l’ensemble du site.</textarea>
    <button onclick="sendRemoved(currentPostId, currentOwnerId)" style="width: 100%; padding: 10px; margin-top: 20px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">Envoyer une notification</button>
</div>


</body>

</html>