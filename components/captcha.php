<?php require 'secret_keys.php'; ?>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<form action="<?= BASE_URL . "register/confirm" ?>" method="POST">
    <div class="g-recaptcha" data-sitekey="<?= $secretEPseminarska['siteKeyCAPTCHA'] ?>"></div>
    <br/>
    <input type="submit" value="Confirm registration">
</form>
