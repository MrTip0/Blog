<?php 
require_once __DIR__ . '/../lib/auth.php';
$json = json_decode(file_get_contents('php://input'), true);
$user = $json["user"];
$pass = $json["pass"];
if (!filter_var($user, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(
        array(
            "result" => "error",
            "reason" => "not valid email address"
        )
    );
} else {
    $token = encode($user, $pass);
    if ($token["res"] == "failure") {
        echo json_encode(
            array(
                "result" => "error",
                "reason" => $token["body"]
            )
        );
    } else {
        setcookie(
            name: "jwt",
            value: $token["body"],
            path:'/',
            domain: $_SERVER['SERVER_NAME'],
            secure: true,
            httponly: true,
            expires_or_options: time() + 60 * 60 * 24 * 60 # Expires after 2 months
        );
        echo json_encode(
            array(
                "result" => "success"
            )
        );
    }
}

?>