<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Recommend Artisan</title>

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

<nav class="navbar">
    <ul>
        <li><a href="index.php">HomePage</a></li> |
        <li><a href="admin.php">Admin Page</a></li>
    </ul>
</nav>

<h3>Recommend a Skilled Artisan</h3>

<?php
session_start();

// Check for success or error messages
if (isset($_SESSION['success_message'])): ?>
    <div class="toast toast-success">
        <span class="icon">&#x2714;</span>
        <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
        <span class="close-toast" onclick="this.parentElement.style.display='none';">&times;</span>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="toast toast-error">
        <span class="icon">&#x26A0;</span>
        <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
        <span class="close-toast" onclick="this.parentElement.style.display='none';">&times;</span>
    </div>
<?php endif; ?>

<form action="includes/handleforms.php" method="post">
    <label for="name">Name
        <input type="text" name="name" id="name" required>
    </label>
    <br>
    <label for="skill">Creative Skill
        <input type="text" name="skill" id="skill" required>
    </label>
    <br>
    <label for="email">Email
        <input type="email" name="email" id="email" required>
    </label>
    <br>
    <label for="phone">Phone
        <input type="text" name="phone" id="phone" required>
    </label>
    <br>
    <input type="submit" name="submit" id="submit" value="Recommend">
</form>

</body>
</html>
