<?php
require __DIR__ . "/../vendor/autoload.php";
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

function decode(string $token) {
    require_once __DIR__ . '/../keys.php';
    return JWT::decode($token, new Key(getpublic(), 'RS256'));
}

function encode(string $username, string $password): array {
    require_once __DIR__ . '/db.php';
    require_once __DIR__ . '/../keys.php';
    $db = getDB();
    $hashedpass = sha1($password, false);
    $res = $db -> query("SELECT password, name from users WHERE username = '$username';");
    if($res -> num_rows != 1)
        return array(
            "res" => "failure",
            "body" => "user not found"
        );
    $row = $res -> fetch_row();
    if ($row[0] == $hashedpass) {
        return array(
            "body" => JWT::encode(array(
                        "username" => $username,
                        "name" => $row[1]
                    ), getprivate(), 'RS256'),
            "res" => "success"
        );
    }
    $db -> close();
    return array(
        "res" => "failure",
        "body" => "wrong password"
    );
}
?>