<?php

    require("../includes/config.php"); 
    
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("quote_form.php", ["title" => "Quote"]);
    }
    
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $stock = lookup($_POST["symbol"]);
        if ($stock == false)
        {
            apologize("You have entered an invalid symbol");
        }
        else 
        {
            render("quote.php", ["title" => $stock["symbol"], "name" => $stock["name"], "price" => $stock["price"]]);
        }
    }
?>
