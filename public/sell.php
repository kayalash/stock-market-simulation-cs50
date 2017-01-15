<?php

    require("../includes/config.php"); 
    
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("sell_form.php", ["title" => "Sell"]);
    }
    
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $stock = lookup(strtoupper ($_POST["symbol"]));
        if ($stock == false)
        {
            apologize("You have entered an invalid symbol");
        }
        else 
        {
            $stock_u = CS50::query("SELECT * FROM portfolios WHERE user_id = ? AND symbol = ?", $_SESSION["id"], $stock["symbol"]);
            if (!$stock_u)
            {
                apologize("You do not currently own any shares of the provided symbol");
            }
            else
            {   
                $shares = $stock_u[0]["shares"];
                if ($shares < $_POST["shares"])
                {
                    apologize("You do not currently own enough shares of the provided symbol");
                }
                elseif (!preg_match("/^\d+$/", $_POST["shares"]))
                {
                    apologize("You have entered an invalid number of shares");
                }
                else
                {
                    if ($shares == $_POST["shares"])
                    {
                        
                        CS50::query ("DELETE FROM portfolios WHERE user_id = ? AND symbol = ?", $_SESSION["id"], $stock["symbol"]);
                    }
                    else 
                    {
                        CS50::query ("UPDATE portfolios SET shares = shares - ? WHERE id = ?", $_POST["shares"], $_SESSION["id"]);
                    }
                    CS50::query ("UPDATE users SET cash = cash + ? WHERE id = ?", $stock["price"] * $_POST["shares"], $_SESSION["id"]);
                    
                    CS50::query ("INSERT INTO history (user_id, action, symbol, shares, price, timestamp) VALUES(?, ?, ?, ?, ?, CURRENT_TIMESTAMP)", $_SESSION["id"], "Sold", $stock["symbol"], $_POST["shares"], $stock["price"]);
                    render ("sell.php", ["title" => "Shares Sold", "stock" => $stock, "shares" => $_POST["shares"]]);
                }
        }   }
    }
?>