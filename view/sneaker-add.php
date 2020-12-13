<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Add new</title>

<h1>Add new sneakers</h1>

<p>[
<a href="<?= BASE_URL . "sneakers" ?>">All sneakers</a> |
<a href="<?= BASE_URL . "sneakers/add" ?>">Add new</a>
]</p>

<form action="<?= BASE_URL . "sneakers/add" ?>" method="post">
    <p><label>Title: <input type="text" name="title" value="<?= $title ?>" /></label></p>
    <p><label>Price: <input type="number" name="price" value="<?= $price ?>" /></label></p>
    <p><label>Size: <input type="number" min="20" max="60" name="size" value="<?= $size ?>" /></label></p>
    <p><label>Active: <input type="number" min="0" max="1" name="active" value="<?= $active ?>" /></label></p>
    <p><label>Company: <input type="number" name="idCompany" value="<?= $idCompany ?>" /></label></p>
    <p><label>Color: <input type="number" name="idColor" value="<?= $idColor ?>" /></label></p>
    <p><label>Image: <input type="text" name="image" value="<?= $image ?>" /></label></p>
    <p><label>Description: <br/><textarea name="description" cols="70" rows="10"><?= $description ?></textarea></label></p>
    <p><button>Insert</button></p>
</form>
