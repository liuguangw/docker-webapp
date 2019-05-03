<?php
$dbname = 'mysql';
$host = getenv('DB_HOST');
$dbuser = 'root';
$dbpass = 'p123456';
try {
    $dbh = new PDO("mysql:dbname=$dbname;host=$host", $dbuser, $dbpass);
    echo '<h3 style="color:green">', 'connect to db success !', '</h3>';
} catch (PDOException $e) {
    echo '<h3 style="color:red">', $e->getMessage(), '</h3>';
}