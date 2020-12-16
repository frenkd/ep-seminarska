<h2>Order details</h2>

<!-- Order details -->
<ul>
    <table style="width:70%">
        <tr>
            <td><b>ID</b></td>
            <td><b>Status</b></td>
            <td><b>Timestamp</b></td>
            <td><b>User ID</b></td>
            <td><b>User Email</b></td>
            <td><b>Amount</b></td>
        </tr>
        <tr>
            <td><?= $order["id"] ?> </td>
            <td><?= $order["status"] ?> </td>
            <td><?= $order["timestamp"] ?> </td>
            <td><?= $order["idUser"] ?> </td>
            <td><?= $order["email"] ?> </td>
            <td><?= $order["amount"] ?> </td>
        </tr>
    </table>
</ul>

<!-- Order items -->
<ul>
    <table style="width:70%">
        <tr>
            <td><b>Product</b></td>
            <td><b>Company</b></td>
            <td><b>Color</b></td>
            <td><b>Size</b></td>
            <td><b>Price per item</b></td>
            <td><b>Quantity</b></td>
            <td><b>Amount</b></td>
        </tr>
        <?php foreach ($orderItems as $u): ?>
            <tr>
                <td><?= $u["title"] ?> </td>
                <td><?= $u["company"] ?> </td>
                <td><?= $u["color"] ?> </td>
                <td><?= $u["price"] ?> </td>
                <td><?= $u["size"] ?> </td>
                <td><?= $u["quantity"] ?> </td>
                <td><?= $u["amount"] ?> </td>
            </tr>
        <?php endforeach; ?>
    </table>
</ul>

<?= isset($confirmForm) ? $confirmForm : "" ?>
<?= isset($cancelForm) ? $cancelForm : "" ?>
<?= isset($revokeForm) ? $revokeForm : "" ?>