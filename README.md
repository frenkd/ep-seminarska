# EP-Seminarska (Electronic business coursework final project @FRI2020)
Implemented a simple webstore in PHP from scratch, including MySQL database design, REST API implementation and usage of some libraries, such as PHPMailer, reCAPTCHA, QuickForm2 and more.


## Key configuration
You need to edit the "secret_keys" with valid values for the project to run.

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
## Apache
You also need to add files from /apacheconf to the Apache server directory.
