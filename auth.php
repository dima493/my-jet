<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $users = file('../databases/users.txt', FILE_IGNORE_NEW_LINES);

    foreach ($users as $line) {
        list($stored_user, $stored_hash) = explode(":", $line);
        
        if ($username === $stored_user && password_verify($password, $stored_hash)) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit;
        }
    }

    echo "Invalid credentials. <a href='login.php'>Try again</a>";
}
?>