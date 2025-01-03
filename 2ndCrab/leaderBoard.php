<?php
//this page does not redirect
//this page is just script
//like a function

session_start();


// Attempts to connect to mysql data base
require_once "connection.php";

try {
    
    $sql = "SELECT u.username , c.crabs FROM (
     SELECT user_id , crabs
        FROM counters
        ORDER BY crabs DESC
        LIMIT 10
        ) AS c 
        JOIN users u ON c.user_id = u.user_id;
        ";
  

    $statements = $connection->prepare($sql);
    $statements->execute();
    $data = $statements->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION['topCrabs'] = $data;
    
    foreach ($_SESSION['topCrabs'] as $row) {
        $temparra = $row;
        echo "<p class='lbName'>" . $temparra["username"] . "</p>" . "  " ."<p class='lbCrabs'>" . $temparra["crabs"] . "</p>" ;        



    }
    
}

catch (Exception $e){
    $_SESSION["error"] = "Error caught: " . $e->getMessage();
    header('Location: http://localhost/2ndCrab/3rdCrab/index2.php');
    return;
}

?>