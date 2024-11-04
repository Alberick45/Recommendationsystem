
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!--  <link rel="stylesheet" href="style.css"> -->
    <link rel="stylesheet" href="styles.css">
    <title>Document</title>
</head>
<body>

<nav class="navbar">
        <ul>
            <li>
                <a href="index.php">HomePage</a>
            </li>
            |
            <li>
                <a href="admin.php">Admin Page</a>
            </li>
        </ul>
    </nav>


    <h3>Recommend a skilled artisan</h3>

    <form action="includes/handleforms.php" method="post">
            <label for="name">
                 Name
                <input type="text" name="name" id="name" required>
            </label>
            <br>
            <label for="skill">
                Creative Skill
                <input type="text" name="skill" id="skill" required>
            </label>
            <br>
            <label for="email">
                    Email
                <input type="email" name="email" id="email" required>
            </label>
            <br>
            <label for="phone">
                Phone
                <input type="phone" name="phone" id="phone" required>
            </label>
            <input type="submit" name="submit" id="submit">
        </form>
</body>
</html>