<?php

    // configuration
    require("../includes/config.php"); 

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("reset_pass_form.php", ["title" => "Reset Password"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["current"]))
        {
            apologize("You must provide your current password.");
        }
        else if (empty($_POST["new"]))
        {
            apologize("You must provide your new password.");
        }
        else if ($_POST["new"] != $_POST["new_confirm"])
        {
            apologize("Passwords do not match.");
        }

        // query database for user
        $rows = CS50::query("SELECT * FROM users WHERE id = ?", $_SESSION["id"]);

        // if we found user, check password
        if (count($rows) == 1)
        {
            // first (and only) row
            $row = $rows[0];

            // compare hash of user's input against hash that's in database
            if (password_verify($_POST["current"], $row["hash"]))
            {
                CS50::query("UPDATE users SET hash = ? WHERE id = ?", password_hash($_POST["new"], PASSWORD_DEFAULT), $_SESSION["id"]);
                
                render ("account.php", ["title" => "Password Reset"]);
            }
        }

        // else apologize
        apologize("Invalid password.");
    }

?>
