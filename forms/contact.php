<!-- filepath: /c:/git/portfolio/forms/contact.php -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form data
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // Check that data was sent to the mailer.
    if (empty($name) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Set a 400 (bad request) response code and exit.
        http_response_code(400);
        echo "Bitte füllen Sie das Formular vollständig aus und versuchen Sie es erneut.";
        exit;
    }

    // Recipient email address.
    $recipient = "adrienfepessi1@gmail.com";

    // Email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Subject: $subject\n\n";
    $email_content .= "Message:\n$message\n";

    // Email headers
    $email_headers = "From: $name <$email>";

    // Send the email.
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // Set a 200 (okay) response code.
        http_response_code(200);
        echo "Vielen Dank! Ihre Nachricht wurde gesendet.";
    } else {
        // Set a 500 (internal server error) response code.
        http_response_code(500);
        echo "Es gab ein Problem beim Senden Ihrer Nachricht. Bitte versuchen Sie es später erneut.";
    }

} else {
    // Not a POST request, set a 403 (forbidden) response code.
    http_response_code(403);
    echo "Es gab ein Problem mit Ihrer Anfrage. Bitte versuchen Sie es erneut.";
}
?>