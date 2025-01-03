<?php
try {
    $connection = new PDO ('mysql:host=localhost;port=3306;dbname=accounts', 'root', '');
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo 'connection error';
    return;
}
?>