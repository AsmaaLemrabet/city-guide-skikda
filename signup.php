<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);

        $_SESSION['user'] = [
            'id' => $conn->lastInsertId(),
            'username' => $username,
            'email' => $email,
            'role' => 'user'
        ];

        header("Location: user-dashboard.php");
        exit();

    } catch (PDOException $e) {
        echo "❌ Error: " . $e->getMessage();
    }
}
?>
