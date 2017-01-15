<?php

    // configuration
    require("../includes/config.php"); 

    $rows = CS50::query("SELECT * FROM history WHERE user_id = ?", $_SESSION["id"]);
    $events = [];
    foreach ($rows as $row)
    {
        $stock = lookup($row["symbol"]);
        if ($stock !== false)
        {
            $events[] = [
                "action" => $row["action"],
                "name" => $stock["name"],
                "price" => $row["price"],
                "shares" => $row["shares"],
                "symbol" => $row["symbol"],
                "timestamp" => $row["timestamp"]
            ];
        }
    }
    
    // render history
    render("history.php", ["events" => $events, "title" => "History", ]);

?>