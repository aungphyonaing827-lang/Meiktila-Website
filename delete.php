<?php
session_start();
include 'db_connect.php';

// Login ဝင်ထားသူဖြစ်ရမည်
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // အရင်ဆုံး ပုံအမည်ကို ယူပြီး folder ထဲက ဖျက်မည်
    $res = mysqli_query($conn, "SELECT image_path FROM contents WHERE id = $id");
    $row = mysqli_fetch_assoc($res);
    if ($row) {
        unlink("Images/" . $row['image_path']); // ပုံကို ဖျက်ခြင်း
    }

    // Database ထဲက row ကို ဖျက်ခြင်း
    $sql = "DELETE FROM contents WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('ဖျက်ပြီးပါပြီ'); window.location='admin.php';</script>";
    }
}
?>