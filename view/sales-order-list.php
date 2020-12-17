<h2>All orders</h2>

<ul>
    <table style="width:100%">
        <tr><b>
            <td><b>ID</b></td>
            <td><b>Status</b></td>
            <td><b>Timestamp</b></td>
            <td><b>User ID</b></td>
            <td><b>User Email</b></td>
            <td><b>Amount</b></td>
        </tr>
        <?php foreach ($orders as $u): ?>
            <tr>
                <td><?= $u["id"] ?> </td>
                <td><?= $u["status"] ?> </td>
                <td><?= $u["timestamp"] ?> </td>
                <td><?= $u["idUser"] ?> </td>
                <td><?= $u["email"] ?> </td>
                <td><?= $u["amount"] ?> </td>
                <td>
                <form action="<?= BASE_URL . "sales/order/" . $u["id"] ?>" method="post">
                    <input type="hidden" name="idUser" value="<?= $u["idUser"] ?>"/>
                    <a href="javascript:;" onclick="parentNode.submit();">Edit</a>
                </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</ul>