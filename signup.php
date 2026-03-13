<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Sign Up</title>
</head>
<body>
    <header>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="materials.php">Materials</a></li>
                <li><a href="login.php">Sign In</a></li>
            </ul>
        </nav>
    </header>

    <div class="sign">
        <div class="sign-card">
            <h2>Create Account</h2>
            <form action="register.php" method="POST">
                <input class="inp-s" type="text" name="new_user" placeholder="Choose Username" required>
                <input  class="inp-s" type="password" name="new_pass" placeholder="Choose Password" required>
                <button class="btn-s" type="submit">Sign Up</button>
            </form>
            <p><a href="login.php">Already have an account? Sign In</a></p>
        </div>
    </div>
</body>
</html>