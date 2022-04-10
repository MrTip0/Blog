<?php
require '../vendor/autoload.php';
use \Firebase\JWT\JWT;

$decoded = json_decode(file_get_contents('php://input'));

if(!empty($decoded -> username) && !empty($decoded -> name) && !empty($decoded -> password)) {
    require_once '../lib/db.php';
    $db = getDB();
    if ($db -> query("SELECT username FROM users WHERE username = '" . $decoded -> username . "';") -> num_rows == 0 ) {
        $token = JWT::encode(array(
            "username" => $decoded -> username,
            "name" => $decoded -> name,
            "password" => sha1($decoded -> password),
            "expire" => time() + (24 * 60 * 60)
        ), getprivate(), 'RS256');
        $message = 'End registration to tipettblog: '. $_SERVER["SERVER_NAME"] .'/accounts/endregistration.php?token=' . $token;
        $resmail = mail($decoded -> username, 'Verifica account', $message);
        if ($resmail) {
            echo '{"result":"success","reason":"Email sent succesfully"}';
        } else {
            echo '{"result":"failure","reason":"Unable to send the email"}';
        }
    } else {
        echo '{"result":"failure","reason":"Username already registered"}';
    }
    $db -> close();
} else {
    http_response_code(400);
    echo '{"result":"failure","reason":"Bad Request"}';
}
?>