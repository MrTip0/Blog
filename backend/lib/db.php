<?php
function getDB(): mysqli
{
    $servername = "localhost";
    $username = "app";

    // Create connection
    $conn = new mysqli(hostname: $servername, username: $username, database: "applittle");
    return $conn;
}
?>