<?php
session_start();


// Attempts to connect to mysql data base
require_once "connection.php";

// Try to add user data via POST to db.
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // If both fields were filled then we try login
        if (isset($_POST['newEmail']) && isset($_POST['newPassword']) && isset($_POST['newUsername'])) {
            // String to check if record exist with passed information
            // Note: The usage of 1 here prevents usage of data, replace
            // with * if access to the record is needed
            // $_POST['Email'] refers to ether the email or username
            $sql = "SELECT 1 FROM users WHERE (username=:Username OR email=:Email) AND password=:Password";
            echo "AHHHHHH1";

            // This prepare statement escapes/sanitizes user entered data
            $statements = $connection->prepare($sql);
            // If this point is reached then passed data is 'safe' and command occurs
            $statements->execute(array(
                ':Username' => $_POST['newUsername'],
                ':Email' => $_POST['newEmail'],
                ':Password' => $_POST['newPassword']
            ));
            // If user was not found then injection is tried
            // Note: fetchColumn() returns 1 meaning true and 0 meaning false
            if (!((bool)$statements->fetchColumn())) {
                // String to insert data to db
                $sql = "INSERT INTO users (username, email, password) VALUES (:Username, :Email, :Password)";
echo "AHHHHHH22";
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




            if ((bool)$statements->fetchColumn()) {
                $_SESSION["account"] = $_POST['newEmail'];
                $_SESSION["error"] = "Account already exsist.";   
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
            header('Location: http://localhost/2ndCrab/3rdCrab/index2.php');
            return;
        }
    }
    
} catch (Exception $e) {
    // If this point is reached then passed data does not match 
    // an existing account or addition of data failed. 

    $_SESSION["error"] = "Email is already in use";
        header('Location: http://localhost/2ndCrab/');
    return;
}

echo "<pre>";
print_r($_POST);



?>
