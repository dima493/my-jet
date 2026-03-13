<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Home</title>
</head>
<body>
    <header>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="materials.php">Materials</a></li>
                <li><a href="shredule.php">Shredule</a></li>
                <li><a href="login.php">Sign In</a></li>
            </ul>
        </nav>
    </header>

    <div align="center">
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = $_POST['new_user'];
        $pass = password_hash($_POST['new_pass'], PASSWORD_DEFAULT); 
        
        $entry = $user . ":" . $pass . PHP_EOL;
        
        file_put_contents('../databases/users.txt', $entry, FILE_APPEND);
        
        echo ("<h2>Account created! Now you can <a href='login.php'>Sign In</a>!</h2>");
    }
    ?>
    </div>
</body>
</html>


