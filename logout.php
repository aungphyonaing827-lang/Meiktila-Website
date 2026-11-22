<?php
session_start();
session_destroy(); // Session အကုန်ဖျက်မယ်
header("Location: login.php"); // Login ဆီ ပြန်ပို့မယ်
exit();
?>