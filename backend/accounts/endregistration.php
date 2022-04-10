<?php
require '../vendor/autoload.php';
require_once '../keys.php';
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

$token = $_GET["token"];
if (!empty($token)) {
    $decoded = JWT::decode($token, new Key(getpublic(), 'RS256'));
    if (time() < $decoded -> expire) {
        require '../lib/db.php';
        $db = getDB();
        $username = $decoded -> username;
        $name = $decoded -> name;
        $password = $decoded -> password;
        $q = $db -> prepare("INSERT INTO users(name, username, password, admin) VALUES (?, ?, ?, 0);");
        $q -> bind_param("sss", $name, $username, $password);
        $res = $q -> execute();
        $db -> close();
        if($res) {
            echo 'Registration successful';
            require '../lib/auth.php';
            $cook = JWT::encode(array(
                "username" => $username,
                "name" => $name
            ), getprivate(), "RS256");
            setcookie(
                name: "jwt",
                value: $cook,
                path:'/',
                domain: $_SERVER['SERVER_NAME'],
                secure: true,
                httponly: true
            );
        } else {
            echo 'Registration failed';
        }
    } else {
        echo 'Time expired';
    }
} else {
    http_response_code(400);
}
?>