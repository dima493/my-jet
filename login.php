<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Sign In</title>
</head>
<body>
    <header>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="materials.php">Materials</a></li>
                <li><a href="shredule.php">Shredule</a></li>
                <li><a href="signup.php">Sign Up</a></li>
            </ul>
        </nav>
    </header>

    <div class="sign">
        <div class="sign-card">
            <h2>Sign In</h2>
            <form action="auth.php" method="POST">
                <input class="inp-s" type="text" name="username" placeholder="Username" required>
                <input class="inp-s" type="password" name="password" placeholder="Password" required>
                <button class="btn-s" type="submit">Sign In</button>
            </form>
            <p><a href="signup.php">Don't have an account? Sign Up</a></p>
        </div>
    </div>
</body>
</html>