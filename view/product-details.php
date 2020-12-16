<title>Sneaker details</title>

<h2>Details of: <?= $title ?></h2>

<ul>
    <li>id: <b><?= $id ?></b></li>    
    <li>Title: <b><?= $title ?></b></li>
    <li>Price: <b><?= $price ?>€</b></li>
    <li>Size: <b><?= $size ?></b></li>
    <li>Description: <i><?= $description ?></i></li>
    <li>Company: <i><?= $company ?></i></li>
    <li>Color: <i><?= $color ?></i></li>

    <!-- Registred customer options -->
    <?php if (isset($_SESSION['idUser']) && $_SESSION['role'] == 'Registred customer'): ?>
        <form action="<?= BASE_URL ?>api/user/cart" method="POST">
            <input type="hidden" name="idProduct" value="<?= $id ?>" />
            <input type="hidden" name="idUser" value="<?= $_SESSION['idUser'] ?>" />
            <button type="submit">Add to cart</button>
        </form>
    <?php endif; ?>
</ul>