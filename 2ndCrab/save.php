<?php
session_start();


// Attempts to connect to mysql data base
require_once "connection.php";


// Try to add user data via POST to db.
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // If both fields were filled then we try login
        if (isset( $_SESSION["user"]) && isset($_POST ['crabCount'])) {
           //updates the users data 
            $sql = "UPDATE counters
                    SET crabs = :crabs, firstItem = :firstItem, secondItem = :secondItem, 
                        thirdItem = :thirdItem, fourthItem = :fourthItem, fithItem = :fithItem
                    WHERE user_id = :user_id";

            // This prepare statement escapes/sanitizes user entered data
            $statements = $connection->prepare($sql);
            // If this point is reached then passed data is 'safe' and command occurs
            $statements->execute(array(
                ':user_id' => $_SESSION["user"], 
                ':crabs' => $_POST ['crabCount'],
                ':firstItem' => $_POST ['firstCount'],
                ':secondItem' => $_POST ['secondCount'],
                ':thirdItem' => $_POST ['thirdCount'],
                ':fourthItem' => $_POST ['fourthCount'],
                ':fithItem' => $_POST ['fithCount']
            ));
        
            $_SESSION["crabs"] = $_POST ['crabCount'];
            $_SESSION["firstItem"] = $_POST ['firstCount'];
            $_SESSION["secondItem"] = $_POST ['secondCount'];
            $_SESSION["thirdItem"] = $_POST ['thirdCount'];
            $_SESSION["fourthItem"] = $_POST ['fourthCount'];
            $_SESSION["fithItem"] = $_POST ['fithCount'];
        
        }
             require_once "leaderBoard.php";
            header('Location: http://localhost/2ndCrab/3rdCrab/index2.php');
            return;
        }
} catch (Exception $e) {
    // If this point is reached then passed data does not match 
    // an existing account or addition of data failed. 

    $_SESSION["error"] = "can not save";
        header('Location: http://localhost/2ndCrab/');
    return;
}

echo "<pre>";
print_r($_POST);



?>