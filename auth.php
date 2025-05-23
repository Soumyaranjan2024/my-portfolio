<?php
session_start();
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $user['username'];
        header('Location: admin.php');
        exit;
    } else {
        $login_error = "Invalid username or password";
    }
}

function isAdminLoggedIn()
{
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function logout()
{
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit;
}

if (isset($_GET['logout'])) {
    logout();
}
?>