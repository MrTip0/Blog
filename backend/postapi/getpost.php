<?php
require '../lib/db.php';

$db = getDB();

$link = $_GET["link"];

$q = $db -> query("SELECT title, description, body FROM posts WHERE link = '$link';");

if ($q -> num_rows != 1) {
    echo '{"error":"post not found"}';
} else {
    $row = $q -> fetch_array();
    echo json_encode(array(
        "title" => $row["title"],
        "description" => $row["description"],
        "body" => $row["body"]
    ));
}
?>