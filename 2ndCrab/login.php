<?php
session_start();

// Attempts to connect to MySQL database
require_once "connection.php";

// Try to add user data via POST to the database.
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if both fields were filled then we try to login
        if (isset($_POST['Email']) && isset($_POST['Password'])) {
            // String to check if record exists with passed information
            $sql = "SELECT * FROM users WHERE (username = :Email OR email = :Email) AND password = :Password";

            // This prepare statement escapes/sanitizes user-entered data
            $statements = $connection->prepare($sql);
            // Execute the prepared statement
            $statements->execute(array(
                ':Email' => $_POST['Email'],
                ':Password' => $_POST['Password']
            ));

            // Fetch user data
            $data = $statements->fetch(PDO::FETCH_ASSOC);

            // If no user found
            if ($data === false) {
                $_SESSION["error"] = "Incorrect username or password.";
                header('Location: http://localhost/2ndCrab/');
                return;
            }

            // Get user ID
            $userIds = $data['user_id'];

            // Retrieve counters for the user
            $sql = "SELECT * FROM counters WHERE user_id = :userid";
            $statements = $connection->prepare($sql);
            $statements->execute(array(':userid' => $userIds));

            // Fetch counter data
            $result = $statements->fetch(PDO::FETCH_ASSOC);



            // Check if result is not false
            if ($result !== false) {

                $itemKeys = ['crabs', 'firstItem', 'secondItem', 'thirdItem', 'fourthItem', 'fithItem'];

                if (isset($itemKeys)) {
                    foreach ($itemKeys as $key) {
                        if (isset($result[$key])) {
                            $_SESSION[$key] = $result[$key];
                        } else {
                            $_SESSION[$key] = 0;
                        }
                    }
                }
            } else {
                // Default values if no counters found
                $_SESSION["crabs"] = 0;
                $_SESSION["firstItem"] = 0;
                $_SESSION["secondItem"] = 0;
                $_SESSION["thirdItem"] = 0;
                $_SESSION["fourthItem"] = 0;
                $_SESSION["fithItem"] = 0;
                $_SESSION["debug"] = "no counters";
            }

            // Store account info in session
            $_SESSION["user"] =  $data['user_id'];
            $_SESSION["account"] = $_POST['Email'];
            $_SESSION["success"] = "Logged in successfully.";




            try {

                $mysql = "SELECT username FROM users WHERE user_id=:user_id";
                $statements = $connection->prepare($mysql);
                $statements->execute(array(
                    ':user_id' => $_SESSION["user"]
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




            require_once "leaderBoard.php";
            header('Location: http://localhost/2ndCrab/3rdCrab/index2.php');
            return;
        }
    }
} catch (Exception $e) {
    // Catch any exceptions and set the error message
    $_SESSION["error"] = "Error caught: " . $e->getMessage();
    header('Location: http://localhost/2ndCrab/');
    return;
}


//MAKE IT SO NO COMPIES OF THE SAME EMAIL EXISIT WHEN LOGGING IN 