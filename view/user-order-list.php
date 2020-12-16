<h2>My orders</h2>

<ul>
    <table style="width:100%">
        <tr><b>
            <td><b>Status</b></td>
            <td><b>Timestamp</b></td>
            <td><b>Amount</b></td>
        </tr>
        <?php foreach ($orders as $u): ?>
            <tr>
                <td><?= $u["status"] ?> </td>
                <td><?= $u["timestamp"] ?> </td>
                <td><?= $u["amount"] ?> </td>
                <td>
                    <a href="<?= BASE_URL . "user/order/" . $u["id"] ?>">Edit</a>
                </td>
            </tr>
        <?php endforeach; ?>
        
    </table>
</ul>