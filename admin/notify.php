<?php
session_start();
include '../backend/connection/db_conn.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id'])) {
        header("Location: job-request.php?status=error&message=No ID provided");
        exit;
    }

    $id = (int)$_POST['id'];

    $stmt = $conn->prepare("SELECT email, name, service FROM uploads WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $customer = $result->fetch_assoc();

    if ($customer) {
        $email = $customer['email'];
        $name = $customer['name'];

        $query = "UPDATE uploads SET isNotified = 1 WHERE id = $id";
        if ($conn->query($query) === TRUE) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; 
                $mail->SMTPAuth = true;
                $mail->Username = 'gonzagayuri760@gmail.com'; 
                $mail->Password = 'knhx yckp ujft yqqh'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('gonzagayuri760@gmail.com', 'RDG Printing');
                $mail->addAddress($email, $name);

                $mail->isHTML(true);
                $mail->Subject = 'Notification from RDG Printing';
                $mail->Body    = '
                    <html>
                    <head>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                background-color: #f4f4f4;
                                margin: 0;
                                padding: 20px;
                            }
                            .container {
                                background-color: #ffffff;
                                padding: 20px;
                                border-radius: 5px;
                                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                            }
                            h1 {
                                color: #333;
                            }
                            p {
                                font-size: 16px;
                                line-height: 1.5;
                                color: #555;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <h1 class="text-capitalize">Dear ' . htmlspecialchars($name) . ',</h1>
                            <h1>Your ' . htmlspecialchars($customer['service']) . ' request has been done.</h1>
                            <p>Thank you for choosing us!</p>
                        </div>
                    </body>
                    </html>
                ';
                $mail->AltBody = 'Dear ' . htmlspecialchars($name) . ', This is a notification regarding your job request. Thank you!';
                $mail->AltBody = 'Dear ' . htmlspecialchars($name) . ', This is a notification regarding your job request. Thank you!';

                $mail->send();
                $_SESSION['success_message'] = "Notification sent and email delivered.";
            } catch (Exception $e) {
                $_SESSION['success_message'] = "Notification sent, but email could not be sent. Mailer Error: " . $mail->ErrorInfo;
            }
        } else {
            $_SESSION['success_message'] = "Failed to update notification status.";
        }
    } else {
        $_SESSION['success_message'] = "Customer not found.";
    }

    header("Location: job-request.php");
    exit;
}
