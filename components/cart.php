<?php require_once("model/CartDB.php"); ?>

<div class="cart">
    <h3>Cart</h3>
    <hr>
    <!-- Shopping basket implementation -->
    <p><?php
    $user = ['idUser' => $_SESSION["idUser"]];
    $cartItems = CartDB::getUserCartItems($user);
        if (count($cartItems) > 0) {
            foreach ($cartItems as $cartItem): ?>
                <div>
                    <form action="<?= BASE_URL ?>user/cart/update" method="POST">
                        <a><b><?= $cartItem['title'] ?>:</b></a>
                        <a><?= number_format($cartItem['price'], 2) ?>€</a>
                        <input type="hidden" name="idProduct" value="<?= $cartItem['idProduct']  ?>" />
                        <input type="hidden" name="previousUrl" value="<?= $_SERVER['REQUEST_URI']  ?>" />
                        <input type="number" name="quantity" value="<?= $cartItem['quantity']  ?>">
                        <button type="submit">Update</button>
                    </form>
                </div>
    <?php endforeach; ?>
    <!-- Total price and clear cart -->
    <?php
    $sum = 0;
    foreach ($cartItems as $cartItem):
        $sum = $sum + $cartItem['quantity'] * $cartItem['price'];
    endforeach;
    ?>
        <hr>
        <div>
            <form action="<?= BASE_URL ?>user/cartPurge" method="POST">
                <b>Total amount: <?= number_format($sum, 2) ?>€</b>
                <input type="hidden" name="previousUrl" value="<?= $_SERVER['REQUEST_URI']  ?>" />
                <button type="submit">Clear cart</button>
            </form>
        </div>
        <div>
            <form action="<?= BASE_URL ?>user/checkout" method="POST">
                <input type="hidden" name="idUser" value="<?= $user['idUser']  ?>" />
                <button type="submit">Checkout</button>
            </form>
        </div>
    <?php
    } else {
        echo "Cart is empty.";
    }            
    ?></p>
</div>