<?php include("components/app-bar.php") ?>
<h2>All salesmen</h2>

<ul>
    <table style="width:100%">
        <tr><b>
            <td><b>ID</b></td>
            <td><b>Email</b></td>
            <td><b>Name</b></td>
            <td><b>Surname</b></td>
            <td><b>Active</b></td>
            <td><b>Role</b></td>
        </tr>
        <?php foreach ($salesmen as $u): ?>
            <tr>
                <td><?= $u["id"] ?> </td>
                <td><?= $u["email"] ?> </td>
                <td><?= $u["name"] ?> </td>
                <td><?= $u["surname"] ?> </td>
                <td><?= $u["active"] ?> </td>
                <td><?= $u["role"] ?> </td>
            </tr>
        <?php endforeach; ?>
        
    </table>
</ul>