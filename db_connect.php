<?php
$servername = "localhost"; 
$username = "root";        // XAMPP ၏ default username
$password = "";            // XAMPP ၏ default password (ဗလာထားပါ)
$dbname = "meiktila_db";   // လူကြီးမင်း၏ Database အမည် အမှန်ဖြစ်ရပါမည်

// Database သို့ ချိတ်ဆက်ခြင်း (Create connection)
$conn = mysqli_connect($servername, $username, $password, $dbname);

// ချိတ်ဆက်မှု အဆင်ပြေမပြေ စစ်ဆေးခြင်း (Check connection)
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// မြန်မာစာ အမှန်ကန်ပေါ်စေရန် utf8mb4 ကို အသုံးပြုပါ
mysqli_set_charset($conn, "utf8mb4");
?>