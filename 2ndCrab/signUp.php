<?php
session_start();


// Attempts to connect to mysql data base
require_once "connection.php";

// Try to add user data via POST to db.
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // If both fields were filled then we try login
        if (isset($_POST['newEmail']) && isset($_POST['newPassword']) && isset($_POST['newUsername'])) {
            
            $sql = "SELECT 1 FROM users WHERE (username=:Username)";
            $statements = $connection->prepare($sql);
            // If this point is reached then passed data is 'safe' and command occurs
            $statements->execute(array(
                ':Username' => $_POST['newUsername']
            ));
            
            if ((bool)$statements->fetchColumn()) {
                //$_SESSION["account"] = $_POST['newUsername'];
                $_SESSION["error"] = "Username already in use.";   
                header('Location: http://localhost/2ndCrab/');
                return;
            }
            $_SESSION["test"] = "User open lolxdxdxd";
            
            if (!((bool)$statements->fetchColumn())) {
                // String to insert data to db
                $sql = "SELECT 1 FROM users WHERE (Email=:newEmail)";
                // This prepare statement escapes/sanitizes user entered data
                $statements = $connection->prepare($sql);
                // If this point is reached then passed data is 'safe' and injection occurs
                $statements->execute(array(
                    ':newEmail' => $_POST['newEmail']
                 ));
            
                 if ((bool)$statements->fetchColumn()) {
                    //$_SESSION["account"] = $_POST['newEmail'];
                    $_SESSION["error"] = "Email already in use.";   
                    header('Location: http://localhost/2ndCrab/');
                    return;
                }

                if (!((bool)$statements->fetchColumn())) {
                    $sql = "INSERT INTO users (username, email, password) VALUES (:Username, :Email, :Password)";
                    // This prepare statement escapes/sanitizes user entered data
                    $statements = $connection->prepare($sql);
                    // If this point is reached then passed data is 'safe' and injection occurs
                    $statements->execute(array(
                        ':Email' => $_POST['newEmail'],
                        ':Username' => $_POST['newUsername'],
                        ':Password' => $_POST['newPassword']
                    ));

                    $last_id = $connection->lastInsertId();
                    $sql = "INSERT INTO counters (user_id, crabs, firstItem, secondItem, thirdItem, fourthItem, fithItem) 
                            VALUES (:user_id, :crabs, :firstItem, :secondItem, :thirdItem, :fourthItem, :fithItem)";

                    // This prepare statement escapes/sanitizes user entered data
                    $statements = $connection->prepare($sql);
                    // If this point is reached then passed data is 'safe' and injection occurs
                    $statements->execute(array(
                        ':user_id' => $last_id, 
                        ':crabs' => $_POST ['crabCount'],
                        ':firstItem' => $_POST ['firstCount'],
                        ':secondItem' => $_POST ['secondCount'],
                        ':thirdItem' => $_POST ['thirdCount'],
                        ':fourthItem' => $_POST ['fourthCount'],
                        ':fithItem' => $_POST ['fithCount']
                    ));
                 }
             }



            if ((bool)$statements->fetchColumn()) {
                $_SESSION["error"] = "Please try again later";   
                header('Location: http://localhost/2ndCrab/');
                return;
            }




            try {

                $mysql = "SELECT username FROM users WHERE user_id=:user_id";
                $statements = $connection->prepare($mysql);
                $statements->execute(array(
                    ':user_id' => $last_id
                ));

                $result = $statements->fetch(PDO::FETCH_ASSOC);

                if ($result) {

                    $_SESSION["username"] = $result["username"];
                }
            } catch (Exception $e) {
                // Catch any exceptions and set the error message
                $_SESSION["error"] = "Error caught: " . $e->getMessage();
                header('Location: http://localhost/2ndCrab/');
                return;
            }

            $_SESSION["user"] =  $last_id;
            $_SESSION["crabs"] = $_POST ['crabCount'];
            $_SESSION["firstItem"] = $_POST ['firstCount'];
            $_SESSION["secondItem"] = $_POST ['secondCount'];
            $_SESSION["thirdItem"] = $_POST ['thirdCount'];
            $_SESSION["fourthItem"] = $_POST ['fourthCount'];
            $_SESSION["fithItem"] = $_POST ['fithCount'];


            $_SESSION["account"] = $_POST['newEmail'];
            $_SESSION["success"] = "Logged in.";
            require_once "leaderBoard.php";
            header('Location: http://localhost/2ndCrab/3rdCrab/index2.php');
            return;
        }
    }
    
} catch (Exception $e) {
    // If this point is reached then passed data does not match 
    // an existing account or addition of data failed. 

    $_SESSION["error"] = "an exception was trown";
        header('Location: http://localhost/2ndCrab/');
    return;
}


?>
