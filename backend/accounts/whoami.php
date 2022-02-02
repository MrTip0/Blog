<?php
$res = array(
    "logged" => false,
    "user" => ""
);

if (!empty($_COOKIE["jwt"])) {
    require '../lib/auth.php';
    $token = decode($_COOKIE["jwt"]);
    $res["logged"] = true;
    $res["user"] = $token -> username;
}

echo json_encode($res);
?>