<?php
function getDB(): mysqli
{
    require_once __DIR__ . '/../keys.php';
    $data = getDBAccess();
    $servername = $data["host"];
    $username = $data["username"];
    $database = $data["database"];

    // Create connection
    $conn = new mysqli(hostname: $servername, username: $username, database: $database);
    return $conn;
}
?>