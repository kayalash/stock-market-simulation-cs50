<div id = "middle">
    <table>
    <tr>
        <th>Stock</th>
        <th>Shares</th>
        <th>Current Price</th>
    </tr>
    <?php foreach ($positions as $position): ?>

    <tr>
        <td><?=$position["name"]?> (<?= $position["symbol"] ?>)</td>
        <td><?= $position["shares"] ?></td>
        <td>$<?= $position["price"] ?></td>
    </tr>

<?php endforeach ?>
    <tr>
        <td>CASH</td>
        <td> </td>
        <td>$<?= $cash ?></td>
    </tr>
    </table>
</div>
