<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Edit entry</title>

<h1>Edit sneaker</h1>

<p>[
    <a href="<?= BASE_URL . "sneakers" ?>">All sneakers</a> |
    <a href="<?= BASE_URL . "sneakers/add" ?>">Add new</a>
    ]</p>

<form action="<?= BASE_URL . "sneakers/edit/" . $id ?>" method="post">
<input type="hidden" name="id" value="<?= $id ?>"  />
<p><label>Title: <input type="text" name="title" value="<?= $title ?>" /></label></p>
    <p><label>Price: <input type="number" name="price" value="<?= $price ?>" /></label></p>
    <p><label>Size: <input type="number" min="20" max="60" name="size" value="<?= $size ?>" /></label></p>
    <p><label class="switch">Active:
        <input type="hidden" name="active" value="0" ?>
        <input type="checkbox" name="active" value="1" <?php if($active == 1): ?>checked<?php endif; ?> />
    </label></p>
    <p><label>Color:
        <select name="idColor">
            <?php foreach ($colors as $cid => $name): ?>
                <option value="<?= $cid ?>" <?php if($cid == $idColor): ?>selected="selected"<?php endif; ?>><?= $name ?></option>
            <?php endforeach; ?>
        </select>
    </label></p>
    <p><label>Company:
        <select name="idCompany">
            <?php foreach ($companies as $cid => $name): ?>
                <option value="<?= $cid ?>" <?php if($cid == $idCompany): ?>selected="selected"<?php endif; ?>> <?= $name ?></option>
            <?php endforeach; ?>
        </select>
    </label></p>
    <p><label>Description: <br/><textarea name="description" cols="70" rows="10"><?= $description ?></textarea></label></p>
    <p><button>Update</button></p>
</form>

<form action="<?= BASE_URL . "sneakers/delete/" . $id ?>" method="post">
    <label>Delete? <input type="checkbox" name="delete_confirmation" /></label>
    <button type="submit" class="important">Delete record</button>
</form>
