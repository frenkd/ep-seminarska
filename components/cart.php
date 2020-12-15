<div class="cart">
    <h3>Cart</h3>
    <!-- Shopping basket implementation -->
    <p><?php
        if (isset($_SESSION["cart"])) {
            foreach ($_SESSION["cart"] as $id => $quantity): ?>
                <div>
                    <form action="<?= $url ?>" method="post">
                        <a><?= BazaKnjig::vrniKnjigo($id)->naslov ?></a>
                        <input type="hidden" name="do" value="update_cart" />
                        <input type="hidden" name="id" value="<?= $id ?>" />
                        <input type="number" name="quantity" value="<?= $quantity ?>">
                        <button type="submit">Posodobi</button>
                    </form>
                </div>
    <?php endforeach; ?>
    <!-- Total price and clear cart -->
    <?php
    $sum = 0;
    foreach ($_SESSION["cart"] as $num => $row):
        $sum = $sum + BazaKnjig::vrniKnjigo($num)->cena * $row;
    endforeach;
    ?>
        <div>
            <form action="<?= $url ?>" method="post">
                <input type="hidden" name="do" value="purge_cart" />
                <b>Price: <?= number_format($sum, 2) ?> EUR</b>
                <button type="submit">Clear cart</button>
            </form>
        </div>
    <?php
    } else {
        echo "Cart is empty.";
    }            
    ?></p>
</div>