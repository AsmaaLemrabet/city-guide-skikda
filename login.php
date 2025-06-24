<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
  'id' => $user['id'],
  'username' => $user['username'],
  'email' => $user['email'],
  'role' => $user['role']
];



        header("Location: user-dashboard.php");
        exit();
    } // ❌ Instead of echoing directly
else {
    header("Location: login-form.php?error=1");
    exit();
}

}
?>
