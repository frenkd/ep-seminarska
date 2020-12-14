<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Sneaker details</title>

<h1>Details of: <?= $title ?></h1>

<p>[
    <a href="<?= BASE_URL . "sneakers" ?>">All books</a> |
    <a href="<?= BASE_URL . "sneakers/add" ?>">Add new</a>
    ]</p>

<ul>
    <li>id: <b><?= $id ?></b></li>    
    <li>Title: <b><?= $title ?></b></li>
    <li>Price: <b><?= $price ?>€</b></li>
    <li>Size: <b><?= $size ?></b></li>
    <li>Description: <i><?= $description ?></i></li>
    <li>Company: <i><?= $company ?></i></li>
    <li>Color: <i><?= $color ?></i></li>
</ul>

<p>[ <a href="<?= BASE_URL . "sneakers/edit/" . $id ?>">Edit</a> |
    <a href="<?= BASE_URL . "sneakers" ?>">All sneakers</a> ]</p>
