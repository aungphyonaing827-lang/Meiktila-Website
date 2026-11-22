<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);
    $user = mysqli_real_escape_string($conn, $user);

    $sql = "SELECT * FROM users WHERE username = '$user' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        // password_verify က အခုမှ Hash အသစ်နဲ့ အလုပ်လုပ်ပါလိမ့်မယ်
        if (password_verify($pass, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            header("Location: admin.php");
            exit();
        } else {
            echo "<script>alert('Password မှားနေပါသည်!'); window.location='login.php';</script>";
        }
    } else {
        echo "<script>alert('Username မရှိပါ!'); window.location='login.php';</script>";
    }
}
?>