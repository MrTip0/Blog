<?php
require '../lib/auth.php';
require '../lib/db.php';

$token = decode($_COOKIE["jwt"]);

$username = $token -> username;

$db = getDB();

$user = $db -> query("SELECT * FROM users WHERE username = '$username';") -> fetch_array();

if ($user["admin"] >= 1) {
    $data = json_decode(file_get_contents('php://input'));
    $title = $data -> title;
    $link = urlencode($title);
    $description = $data -> description;
    $cover = $data -> cover;
    $body = $data -> body;
    $author = $user["id"];
    $quer = $db -> prepare("INSERT INTO posts (
        link,
        title,
        description,
        releasedate,
        cover,
        body,
        author
    ) VALUES (
        '$link',
        ?,
        ?,
        curdate(),
        '$cover',
        ?,
        $author
    );");
    $quer -> bind_param("sss", $title, $description, $body);

    if ($quer -> execute()) {
        echo '{"result":"success"}';
    } else {
        echo '{"result":"failure"}';
    }
} else {
    echo '{"result": "failure"}';
}
?>