<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to_email = "jsj220028737@jainuniversity.ac.in"; // Replace with your email address
    $subject = "New Comment from Website";
    
    $name = $_POST["name"];
    $email = $_POST["email"];
    $website = $_POST["website"];
    $message = $_POST["message"];
    
    $body = "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Website: $website\n";
    $body .= "Message:\n$message";
    
    // Headers
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    
    // Sending email
    if (mail($to_email, $subject, $body, $headers)) {
        echo "Your comment has been submitted successfully!";
    } else {
        echo "Failed to send comment. Please try again later.";
    }
}
?>
