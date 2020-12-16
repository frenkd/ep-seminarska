<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Sneaker World</title>

<h1>Sneaker world</h1>

<!-- Anonymous user -->
<?php if (!isset($_SESSION['idUser'])): ?>
    <a href="<?= BASE_URL . "sneakers" ?>">All sneakers</a> |
    <a href="<?= BASE_URL . "login" ?>">Login</a> |
    <a href="<?= BASE_URL . "register" ?>">Register</a> |
<?php endif; ?>

<!-- Registred customer options -->
<?php if (isset($_SESSION['idUser']) && $_SESSION['role'] == 'Registred customer'): ?>
    <a href="<?= BASE_URL . "sneakers" ?>">All sneakers</a> |
    <a href="<?= BASE_URL . "user/orders" ?>">My orders</a> |
<?php endif; ?>

<!-- Salesman options -->
<?php if (isset($_SESSION['idUser']) && $_SESSION['role'] == 'Salesman'): ?>
    <a href="<?= BASE_URL . "sales/users" ?>">Users</a> |
    <a href="<?= BASE_URL . "sales/products" ?>">Products</a> |
<?php endif; ?>

<!-- Admin options -->
<?php if (isset($_SESSION['idUser']) && $_SESSION['role'] == 'Administrator'): ?>
    <a href="<?= BASE_URL . "admin/salesmen" ?>">Salesmen</a> |
<?php endif; ?>

<!-- Settings and logout -->
<?php if (isset($_SESSION['idUser'])): ?>
    <a href="<?= BASE_URL . "settings" ?>">Settings</a> |
    <a href="<?= BASE_URL . "logout" ?>">Logout</a> |
<?php endif; ?>