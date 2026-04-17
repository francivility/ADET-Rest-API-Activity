<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'zenfit_db');

// Google Auth
define('GOOGLE_CLIENT_ID', '1020648594389-qoemunkjgeefev54bbi5qtv445ruutsh.apps.googleusercontent.com');

// Mail Settings
define('MAIL_SENDER', 'fmj2023-9039-95126@bicol-u.edu.ph');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    header('Content-Type: application/json');
    die(json_encode(["error" => "Critical System Failure: Database unreachable."]));
}
?>