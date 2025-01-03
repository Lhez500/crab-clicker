<?php
try {
    $connection = new PDO ('mysql:host="enter your host here";port="port goes here";dbname=""db name', '"name"', '"password"');
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo 'connection error';
    return;
}
?>
