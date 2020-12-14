<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Sneaker World</title>

<h1>All sneakers</h1>

<p>[
<a href="<?= BASE_URL . "sneakers" ?>">All sneakers</a> |
<a href="<?= BASE_URL . "sneakers/add" ?>">Add new</a>
]</p>

<ul>

    <?php foreach ($sneakers as $sneaker): ?>
        <li><a href="<?= BASE_URL . "sneakers/" . $sneaker["id"] ?>"><?= $sneaker["title"] ?>: 
        	<?= $sneaker["size"] ?> (<?= $sneaker["description"] ?>)</a></li>
    <?php endforeach; ?>

</ul>