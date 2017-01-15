<div id = "middle">
    <table>
    <tr>
        <th>Action</th>
        <th>Stock</th>
        <th>Shares</th>
        <th>Price</th>
        <th>Timestamp</th>
    </tr>
    <?php foreach ($events as $event): ?>
    
    <tr>
        <td><?= $event["action"] ?></td>
        <td><?= $event["name"] ?> (<?= $event["symbol"] ?>)</td>
        <td><?= $event["shares"] ?></td>
        <td>$<?= $event["price"] ?></td>
        <td><?= $event["timestamp"] ?></td>
    </tr>

<?php endforeach ?>
    </table>
</div>
