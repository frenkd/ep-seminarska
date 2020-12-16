<h2>All sneakers</h2>

<ul>
    <table style="width:100%">
        <tr><b>
            <td><b>ID</b></td>
            <td><b>Title</b></td>
            <td><b>Price</b></td>
            <td><b>Size</b></td>
            <td><b>Company</b></td>
            <td><b>Color</b></td>
            <td><b>Active</b></td>
        </tr>
        <?php foreach ($products as $u): ?>
            <tr>
                <td><?= $u["id"] ?></td>
                <td><a href="<?= BASE_URL . "sales/product/" . $u["id"] ?>"><?= $u["title"] ?></a></td>
                <td><?= $u["price"] ?></td>
                <td><?= $u["size"] ?></td>
                <td><?= $u["company"] ?></td>
                <td><?= $u["color"] ?></td>
                <td><?= $u["active"] ?></td>
                <td>
                    <a href="<?= BASE_URL . "sales/product/edit/" . $u["id"] ?>">Edit</a>
                </td>
            </tr>
        <?php endforeach; ?>
        
    </table>
</ul>