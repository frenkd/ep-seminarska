<h2>Order details</h2>

<ul>
    <table style="width:70%">
        <tr><b>
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
                <td><?= $u["size"] ?> </td>
                <td><?= $u["price"] ?> </td>
                <td><?= $u["quantity"] ?> </td>
                <td><?= $u["amount"] ?> </td>
            </tr>
        <?php endforeach; ?>
    </table>
</ul>