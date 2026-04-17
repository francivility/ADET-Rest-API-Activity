<?php
require 'db_config.php';
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    $name = $conn->real_escape_string($data['fullname']);
    $email = $conn->real_escape_string($data['email']);
    $type = $conn->real_escape_string($data['membership_type']);
    $expiry = date('Y-m-d', strtotime('+30 days'));

    $sql = "INSERT INTO applicants (fullname, email, membership_type, price, expiry_date) 
            VALUES ('$name', '$email', '$type', 500, '$expiry')";

    if ($conn->query($sql)) {
        // --- EMAIL BLOCK ---
        $to = $email;
        $subject = "Welcome to ZenFit - $type Membership";
        $message = "Hello $name,\n\nYour enrollment was successful!\nPlan: $type\nExpires on: $expiry\n\nGet ready to sweat.";
        $headers = "From: " . MAIL_SENDER . "\r\n" .
                   "Reply-To: " . MAIL_SENDER . "\r\n" .
                   "X-Mailer: PHP/" . phpversion();

        // Sending the email
        $mailSent = @mail($to, $subject, $message, $headers);

        echo json_encode(["status" => "success", "mail_sent" => $mailSent]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $conn->query("SELECT * FROM applicants ORDER BY id DESC");
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}
?>