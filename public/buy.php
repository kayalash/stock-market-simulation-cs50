<?php

    require("../includes/config.php"); 
    
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("buy_form.php", ["title" => "Buy"]);
    }
    
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $stock = lookup(strtoupper ($_POST["symbol"]));
        if ($stock == false)
        {
            apologize("You have entered an invalid symbol");
        }
        elseif (!preg_match("/^\d+$/", $_POST["shares"]))
        {
            apologize("You have entered an invalid number of shares");
        }
        else
        {
            $user = CS50::query("SELECT * FROM users WHERE id = ?", $_SESSION["id"]);
            $cash = $user[0]["cash"];
            if ($cash < $_POST["shares"] * $stock["price"])
            {
                apologize ("You do not have enough money to purchase {$_POST["shares"]} shares of {$stock["symbol"]}");
            }
            else 
            {
                CS50::query("INSERT INTO portfolios (user_id, symbol, shares) VALUES(?, ?, ?) ON DUPLICATE KEY UPDATE shares = shares + VALUES(shares)", $_SESSION["id"], $stock["symbol"], $_POST["shares"]);
                CS50::query("UPDATE users SET cash = cash - ? WHERE id = ?", $_POST["shares"] * $stock["price"], $_SESSION["id"]);
                
                CS50::query ("INSERT INTO history (user_id, action, symbol, shares, price, timestamp) VALUES(?, ?, ?, ?, ?, CURRENT_TIMESTAMP)", $_SESSION["id"], "Bought", $stock["symbol"], $_POST["shares"], $stock["price"]);
                render ("buy.php", ["title" => "Shares Bought", "stock" => $stock, "shares" => $_POST["shares"]]);
            }
        }        
    }
?>