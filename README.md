# Konfiguracija ključev
Potrebna je konfiguracija datoteke "secret_keys" v korenu tega projekta.

```
<?php

$secretEPseminarska = [
    'mailUsername' => '',
    'mailEmail' => '',
    'mailPassword' => '',
    'secretCAPTCHA' => '',
    'siteKeyCAPTCHA' => '',
    'confirmationSecret' => ''
];

```
# Apache
V konfiguracijske datoteke je potrebno dodati vsebino iz /apacheconf