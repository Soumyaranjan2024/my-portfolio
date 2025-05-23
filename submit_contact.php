<?php
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'];

    try {
        $stmt = $pdo->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $subject, $message]);

        // Send email notification (optional)
        $to = "soumyaranjanpadhi936@gmail.com";
        $email_subject = "New Contact Form Submission: " . ($subject ?: "No Subject");
        $email_body = "You have received a new message from your portfolio contact form.\n\n" .
            "Name: $name\n" .
            "Email: $email\n" .
            "Subject: $subject\n" .
            "Message:\n$message";
        $headers = "From: $email";

        mail($to, $email_subject, $email_body, $headers);

        // Redirect with success message
        header('Location: index.php?contact=success#contact');
        exit;
    } catch (PDOException $e) {
        // Redirect with error message
        header('Location: index.php?contact=error#contact');
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}
?>