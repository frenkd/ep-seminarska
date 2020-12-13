<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Edit entry</title>

<h1>Edit book</h1>

<p>[
    <a href="<?= BASE_URL . "sneakers" ?>">All books</a> |
    <a href="<?= BASE_URL . "sneakers/add" ?>">Add new</a>
    ]</p>

<form action="<?= BASE_URL . "sneakers/edit/" . $id ?>" method="post">
    <input type="hidden" name="id" value="<?= $id ?>"  />
    <p><label>Title: <input type="text" name="title" value="<?= $title ?>" /></label></p>
    <p><label>Price: <input type="number" name="price" value="<?= $price ?>" /></label></p>
    <p><label>Size: <input type="number" min="20" max="60" name="size" value="<?= $size ?>" /></label></p>
    <p><label>Active: <input type="number" min="0" max="1" name="active" value="<?= $active ?>" /></label></p>
    <p><label>Company: <input type="number" name="idCompany" value="<?= $idCompany ?>" /></label></p>
    <p><label>Color: <input type="number" name="idColor" value="<?= $idColor ?>" /></label></p>
    <p><label>Image: <input type="text" name="image" value="<?= $image ?>" /></label></p>
    <p><label>Description: <br/><textarea name="description" cols="70" rows="10"><?= $description ?></textarea></label></p>
    <p><button>Update record</button></p>
</form>

<form action="<?= BASE_URL . "sneakers/delete/" . $id ?>" method="post">
    <label>Delete? <input type="checkbox" name="delete_confirmation" /></label>
    <button type="submit" class="important">Delete record</button>
</form>
