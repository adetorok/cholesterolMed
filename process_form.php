<?php
// Process form submission and send email
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $firstName = $_POST['firstName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $age = $_POST['age'] ?? '';
    $language = $_POST['language'] ?? 'english';

    // Validate required fields
    $errors = [];
    if (empty($firstName)) $errors[] = "First name is required";
    if (empty($lastName)) $errors[] = "Last name is required";
    if (empty($email)) $errors[] = "Email is required";
    if (empty($phone)) $errors[] = "Phone is required";
    if (empty($age)) $errors[] = "Age is required";

    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
        exit;
    }

    // Prepare email content
    $to = "info@medclinicresearch.com";
    $subject = "New Study Interest - " . ($language === 'spanish' ? 'Spanish' : 'English');
    
    $message = "New study interest form submission received:\n\n";
    $message .= "Language: " . ($language === 'spanish' ? 'Spanish' : 'English') . "\n";
    $message .= "Name: " . $firstName . " " . $lastName . "\n";
    $message .= "Email: " . $email . "\n";
    $message .= "Phone: " . $phone . "\n";
    $message .= "Age: " . $age . "\n";
    $message .= "\nSubmitted on: " . date('Y-m-d H:i:s') . "\n";

    // Email headers
    $headers = "From: noreply@medclinicresearch.com\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send email
    if (mail($to, $subject, $message, $headers)) {
        // Also send confirmation email to the user
        $userSubject = "Thank you for your interest - Medclinic Research";
        $userMessage = "Dear " . $firstName . ",\n\n";
        $userMessage .= "Thank you for your interest in our cholesterol research study.\n\n";
        $userMessage .= "We have received your information and a team member will contact you shortly to discuss your eligibility for our study.\n\n";
        $userMessage .= "If you have any questions, please contact us at:\n";
        $userMessage .= "Phone: 908-798-8373\n";
        $userMessage .= "Email: info@medclinicresearch.com\n";
        $userMessage .= "Website: www.medclinicresearch.com\n\n";
        $userMessage .= "Best regards,\n";
        $userMessage .= "Medclinic Research, LLC";

        $userHeaders = "From: info@medclinicresearch.com\r\n";
        $userHeaders .= "Content-Type: text/plain; charset=UTF-8\r\n";

        mail($email, $userSubject, $userMessage, $userHeaders);

        echo json_encode(['success' => true, 'message' => 'Form submitted successfully!']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to send email. Please try again.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
?>
