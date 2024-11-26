<?php
require_once "./includes/conn.php";
session_start();

// Fetch recommendees
$query = "SELECT * FROM recommendee";
$stmt = $conn->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll();

// Signup handling
if (isset($_POST['submit_signup'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $query = "INSERT INTO recommender (name, phone, email, password) VALUES (:name, :phone, :email, :password)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":phone", $phone);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $hashedPassword);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Signup successful! You can now log in.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $_SESSION['error_message'] = "Error: " . $stmt->errorInfo()[2];
    }
}
//Signin
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommender System</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Toast Notification Styling */
        .toast {
            position: fixed;
            top: 10px;
            right: 10px;
            padding: 15px 20px;
            margin: 5px;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            animation: slide-in 0.5s ease-out;
            z-index: 1000;
        }

        .toast-success {
            background-color: #28a745; /* Green for success */
        }

        .toast-error {
            background-color: #dc3545; /* Red for error */
        }

        .icon {
            font-size: 16px;
        }

        .close-toast {
            margin-left: auto;
            cursor: pointer;
            font-size: 18px;
            color: white;
        }

        @keyframes slide-in {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <ul>
            <li><a href="index.php">HomePage</a></li> |
            <li><a href="admin.php">Admin Page</a></li>
        </ul>
    </nav>

    <!-- Toast Notifications -->
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="toast toast-error">
            <span class="icon">⚠️</span> 
            <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
            <span class="close-toast" onclick="closeToast(this)">✖️</span>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="toast toast-success">
            <span class="icon">✅</span>
            <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
            <span class="close-toast" onclick="closeToast(this)">✖️</span>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="body">
            <h1 class="title-text">Admin Page</h1>
            <h2 class="title-text">List of Recommended Recipients</h2>
            <table class="body">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Skill</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $id = 1;
                    foreach ($results as $recommendee): ?>
                        <tr>
                            <td><?php echo $id ?></td>
                            <td><?php echo $recommendee['name'] ?></td>
                            <td><?php echo $recommendee['skill'] ?></td>
                            <td><?php echo $recommendee['phone'] ?></td>
                            <td><?php echo $recommendee['email'] ?></td>
                            <td>
                                <a href="recommendee_delete.php?id=<?php echo $recommendee['id']?>"><button class="button-delete">Delete</button></a> 
                            </td>
                        </tr>
                    <?php $id++; endforeach; ?>
                </tbody>
            </table>

            <form action="includes/logout.php" method="post">
                <button type="submit" class="btn btn-outline-danger" name="logout" id="logout">Logout</button>
            </form>
        </div>
    <?php else: ?>
        <div class="container" style="display: flex; justify-content: space-between; gap: 20px; ">
            <div id="signup">
                <h3>Signup Here</h3>
                <form action="" method="post">
                    <label for="name">Name <input type="text" name="name" id="name" required></label>
                    <label for="email_signup">Email <input type="email" name="email" id="email_signup" required></label>
                    <label for="phone">Phone <input type="text" name="phone" id="phone" required></label>
                    <label for="password_signup">Password <input type="password" name="password" id="password_signup" required></label>
                    <input type="submit" name="submit_signup" id="submit_signup" value="Sign Up">
                </form>
            </div>

            <div id="center"><h1>OR</h1></div>

            <div id="signin">
                <h3>Signin Here</h3>
                <form action="includes/signin.php" method="post">
                    <label for="email_signin">Email <input type="email" name="email" id="email_signin" required></label>
                    <label for="password_signin">Password <input type="password" name="password" id="password_signin" required></label>
                    <input type="submit" name="submit_signin" id="submit_signin" value="Sign In">
                </form>
            </div>
        </div>
    <?php endif; ?>

    <script>
        // Auto-dismiss toast after 5 seconds
        setTimeout(() => {
            const toasts = document.querySelectorAll('.toast');
            toasts.forEach(toast => toast.style.display = 'none');
        }, 5000);

        // Close toast manually
        function closeToast(element) {
            element.parentElement.style.display = 'none';
        }
    </script>
</body>
</html>
