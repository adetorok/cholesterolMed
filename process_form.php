<?php
// Process form submission and send email
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $interestType = $_POST['interestType'] ?? '';
    $firstName = $_POST['firstName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $age = $_POST['age'] ?? '';
    $eligibility = $_POST['eligibility'] ?? [];
    $contactTime = $_POST['contactTime'] ?? '';
    $referralName = $_POST['referralName'] ?? '';
    $referralPhone = $_POST['referralPhone'] ?? '';
    $additionalInfo = $_POST['additionalInfo'] ?? '';
    $language = $_POST['language'] ?? 'english';

    // Validate required fields
    $errors = [];
    if (empty($firstName)) $errors[] = "First name is required";
    if (empty($lastName)) $errors[] = "Last name is required";
    if (empty($email)) $errors[] = "Email is required";
    if (empty($phone)) $errors[] = "Phone is required";
    if (empty($age)) $errors[] = "Age is required";
    if (empty($eligibility)) $errors[] = "At least one eligibility criteria must be selected";
    if (empty($contactTime)) $errors[] = "Contact time preference is required";
    if ($interestType === 'referring' && (empty($referralName) || empty($referralPhone))) {
        $errors[] = "Referral name and phone are required when referring someone";
    }

    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit;
    }

    // Prepare email content
    $to = "info@medclinicalresearch.com";
    $subject = "New Interest Form Submission - " . ($language === 'spanish' ? 'Spanish' : 'English');
    
    $message = "New interest form submission received:\n\n";
    $message .= "Language: " . ($language === 'spanish' ? 'Spanish' : 'English') . "\n";
    $message .= "Interest Type: " . ($interestType === 'participating' ? 'Participating in study' : 'Referring someone') . "\n";
    $message .= "Name: " . $firstName . " " . $lastName . "\n";
    $message .= "Email: " . $email . "\n";
    $message .= "Phone: " . $phone . "\n";
    $message .= "Age: " . $age . "\n";
    $message .= "Eligibility Criteria Met:\n";
    foreach ($eligibility as $criteria) {
        switch ($criteria) {
            case 'age50':
                $message .= "- At least 50 years old\n";
                break;
            case 'cholesterol':
                $message .= "- Takes cholesterol medication\n";
                break;
            case 'familyHistory':
                $message .= "- Family history of high cholesterol, diabetes, or hypertension\n";
                break;
        }
    }
    $message .= "Preferred Contact Time: " . $contactTime . "\n";
    
    if ($interestType === 'referring') {
        $message .= "\nReferral Information:\n";
        $message .= "Referral Name: " . $referralName . "\n";
        $message .= "Referral Phone: " . $referralPhone . "\n";
    }
    
    if (!empty($additionalInfo)) {
        $message .= "\nAdditional Information:\n" . $additionalInfo . "\n";
    }
    
    $message .= "\nSubmitted on: " . date('Y-m-d H:i:s') . "\n";

    // Email headers
    $headers = "From: noreply@medclinicalresearch.com\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send email
    if (mail($to, $subject, $message, $headers)) {
        // Also send confirmation email to the user
        $userSubject = "Thank you for your interest - MED CLINICAL RESEARCH";
        $userMessage = "Dear " . $firstName . ",\n\n";
        $userMessage .= "Thank you for your interest in our clinical research study.\n\n";
        $userMessage .= "We have received your information and will contact you during your preferred time: " . $contactTime . "\n\n";
        if ($interestType === 'referring') {
            $userMessage .= "We will also contact " . $referralName . " regarding the study.\n\n";
        }
        $userMessage .= "If you have any questions, please contact us at:\n";
        $userMessage .= "Phone: 908-798-8373\n";
        $userMessage .= "Email: info@medclinicalresearch.com\n\n";
        $userMessage .= "Best regards,\n";
        $userMessage .= "MED CLINICAL RESEARCH, LLC";

        $userHeaders = "From: info@medclinicalresearch.com\r\n";
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
