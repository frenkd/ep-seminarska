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
    <p><label class="switch">Active:
        <input type="hidden" name="active" value="0" ?>
        <input type="checkbox" name="active" value="1" checked />
        <span class="slider round"></span>
    </label>
    </label></p>
    <p><label>Color:
        <select name="idColor">
            <?php foreach ($colors as $cid => $name): ?>
                <option value="<?= $cid ?>"><?= $name ?></option>
            <?php endforeach; ?>
        </select>
    </label></p>
    <p><label>Company:
        <select name="idCompany">
            <?php foreach ($companies as $cid => $name): ?>
                <option value="<?= $cid ?>"><?= $name ?></option>
            <?php endforeach; ?>
        </select>
    </label></p>
    <p><label>Image: <input type="text" name="image" value="<?= $image ?>" /></label></p>
    <p><label>Description: <br/><textarea name="description" cols="70" rows="10"><?= $description ?></textarea></label></p>
    <p><button>Insert</button></p>
</form>