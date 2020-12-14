<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Add new</title>

<h1><?= $title ?></h1>

<p>[
<a href="<?= BASE_URL . "sneakers" ?>">All sneakers</a> |
<a href="<?= BASE_URL . "sneakers/add" ?>">Add new</a>
]</p>


<?= $form ?>

<?= isset($deleteForm) ? $deleteForm : "" ?>