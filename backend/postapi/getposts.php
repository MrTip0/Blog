<?php
require __DIR__ . '/../lib/db.php';

$db = getDB();

$data = [];

$res = $db -> query("SELECT title, description, cover FROM posts;");

while($row = $res -> fetch_assoc()) {
    array_push($data, array(
        "link" => urlencode($row["title"]),
        "title" => $row["title"],
        "description" => $row["description"],
        "cover" => $row["cover"]
    ));
}
$db -> close();
echo json_encode($data);
?>