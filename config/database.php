<?php
    define('DB_HOST', 'localhost');
    define('DB_USER', 'mugheez2');
    define('DB_PASS', '123456');
    define('DB_NAME', 'php_project1');

    // make connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // check connection
    if ($conn->connect_error) {
        die('connection failed' . $conn->connect_error);
    }
?>