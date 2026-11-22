<?php
// သင့်နာမည်နဲ့ password ကို ဒီမှာ အစားထိုးပါ
$my_name = "danny"; 
$my_password = "11223344"; 

echo "Your Username: " . $my_name . "<br>";
echo "Your Hashed Password: " . password_hash($my_password, PASSWORD_DEFAULT);
?>