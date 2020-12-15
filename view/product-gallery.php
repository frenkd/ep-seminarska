<?php include("components/app-bar.php") ?>
<h2>All sneakers</h2>

<ul>

    <?php foreach ($sneakers as $sneaker): ?>
        <li><a href="<?= BASE_URL . "sneakers/" . $sneaker["id"] ?>"><?= $sneaker["title"] ?>: 
        	<?= $sneaker["size"] ?> (<?= $sneaker["description"] ?>)</a></li>
    <?php endforeach; ?>

</ul>