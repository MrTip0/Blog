<?php
require '../lib/db.php';

$db = getDB();

$title = $_GET["link"];

$q = $db -> prepare("SELECT title, description, body FROM posts WHERE title = ?;");
$q -> bind_param("s", $title);
$q -> execute();

$res = $q -> get_result();

if ($res -> num_rows != 1) {
    echo '{"error":"post not found"}';
} else {
    $row = $res -> fetch_array();
    echo json_encode(array(
        "title" => $row["title"],
        "description" => $row["description"],
        "body" => $row["body"]
    ));
}
$db -> close();
?>