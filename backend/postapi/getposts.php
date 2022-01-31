<?php
require '../lib/db.php';

$db = getDB();

$data = [];

$res = $db -> query("SELECT link, title, description, cover FROM posts;");

while($row = $res -> fetch_assoc()) {
    array_push($data, array(
        "link" => $row["link"],
        "title" => $row["title"],
        "description" => $row["description"],
        "cover" => $row["cover"]
    ));
}

echo json_encode($data);
?>