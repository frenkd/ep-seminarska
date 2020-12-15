<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Sneaker World</title>

<h1>Sneaker world</h1>

<!-- App bar for page navigation -->
<?php if (!isset($_SESSION['user_id'])): ?>
    <a href="<?= BASE_URL . "sneakers" ?>">All sneakers</a> |
    <a href="<?= BASE_URL . "login" ?>">Login</a> |
    <a href="<?= BASE_URL . "register" ?>">Register</a>
<?php else: ?>
    <a href="<?= BASE_URL . "settings" ?>">Settings</a> |
    <a href="<?= BASE_URL . "logout" ?>">Logout</a>
<?php endif; ?>
