<?php include("components/app-bar.php") ?>
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
            </tr>
        <?php endforeach; ?>
        
    </table>
</ul>