
<?php
session_start();
require_once "conn.php";
require_once "send_email.php";

if (isset($_POST['submit'])) {
    // Sanitize input to prevent SQL injection and XSS attacks
    $name = htmlspecialchars(trim($_POST['name']));
    $skill = htmlspecialchars(trim($_POST['skill']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));

    // Basic Validation
    if (empty($name) || empty($skill) || empty($email) || empty($phone)) {
        $_SESSION['error_message'] = "All fields are required.";
        header("Location: ../index.php");
        exit();
    }

    try {
        // Insert into database
        $query = "INSERT INTO recommendee (name, skill, email, phone) VALUES (:name, :skill, :email, :phone)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':skill', $skill);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);

        if ($stmt->execute()) {
            sendRecommendationEmail($name, $skill, $phone, $email);
            $_SESSION['success_message'] = "Recommendation submitted successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to submit recommendation.";
        }
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
    }

    header("Location: ../index.php");
    exit();
}
?>
