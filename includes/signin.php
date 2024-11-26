<?php
// Signin PHP Script (signin.php)
require_once("conn.php");
session_start();

if (isset($_POST['submit_signin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Email and password are required.";
        header("Location: ../signin.php"); // Redirect back to the signin form
        exit();
    }

    try {
        $query = "SELECT id, email, password FROM recommender WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['success_message'] = "Signin successful. Welcome back!";
                header("Location: ../admin.php"); // Redirect to admin page
                exit();
            } else {
                $_SESSION['error_message'] = "Invalid password.";
                header("Location: ../admin.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "No account found with that email.";
            header("Location: ../admin.php");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "An error occurred: " . $e->getMessage();
        header("Location: ../admin.php");
        exit();
    }
}
?>
