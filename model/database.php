<?php
require_once __DIR__ . '/config.php';

function get_db_connection(): mysqli
{
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $connection->set_charset('utf8mb4');
    return $connection;
}
