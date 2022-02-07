<?php
require '../vendor/autoload.php';
require '../keys.php';
use \Firebase\JWT\JWT;

$decoded = json_decode(file_get_contents('php://input'));

if(!empty($decoded -> username) && !empty($decoded -> name) && !empty($decoded -> password)) {
    require '../lib/db.php';
    $db = getDB();
    if ($db -> query("SELECT username FROM users WHERE username = '" . $decoded -> username . "';") -> num_rows == 0 ) {
        $token = JWT::encode(array(
            "username" => $decoded -> username,
            "name" => $decoded -> name,
            "password" => sha1($decoded -> password),
            "expire" => time() + (24 * 60 * 60)
        ), getprivate(), 'RS256');
        $message = '
        <html>
            <head>
                <title>Thank you for your registration</title>
            </head>
            <body>
                <h1>these are the last steps</h1>
                <a href="'. $_SERVER["SERVER_NAME"] .'/accounts/endregistration.php?token=' . $token . '">End registration</a>
            </body>
        </html>';
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1'; 
        $resmail = mail($decoded -> username, 'Verifica account', $message, implode('\r\n', $headers));
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