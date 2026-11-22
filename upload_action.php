<?php
include 'db_connect.php';

if(isset($_POST['submit'])) {
    // Basic Information
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $cat = mysqli_real_escape_string($conn, $_POST['category']); 
    $sub_cat = isset($_POST['sub_category']) ? mysqli_real_escape_string($conn, $_POST['sub_category']) : '';
    $loc = mysqli_real_escape_string($conn, $_POST['location']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    
    // Transportation Fields
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $schedule = mysqli_real_escape_string($conn, $_POST['schedule']);
    
    // --- Agriculture & Livestock Fields (အသစ်ဖြည့်စွက်ချက်) ---
    $breeding_system = isset($_POST['breeding_system']) ? mysqli_real_escape_string($conn, $_POST['breeding_system']) : '';
    $requirements = isset($_POST['requirements']) ? mysqli_real_escape_string($conn, $_POST['requirements']) : '';
    $health_safety = isset($_POST['health_safety']) ? mysqli_real_escape_string($conn, $_POST['health_safety']) : '';
    $market_benefit = isset($_POST['market_benefit']) ? mysqli_real_escape_string($conn, $_POST['market_benefit']) : '';

    // --- Multiple Images Upload Logic (ပုံ ၃ ပုံအတွက်) ---
    $image_names = ['', '', '']; // ပုံအမည်များ သိမ်းရန် array
    $target_dir = "Images/";

    if (!empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            if ($key > 2) break; // ၃ ပုံထက်ပိုရင် ရပ်မယ်

            $original_name = $_FILES['images']['name'][$key];
            $ext = pathinfo($original_name, PATHINFO_EXTENSION);
            $new_name = time() . "_img" . ($key + 1) . "." . $ext; // နာမည်မတူအောင် အချိန်နဲ့တွဲပေးမယ်
            
            if (move_uploaded_file($tmp_name, $target_dir . $new_name)) {
                $image_names[$key] = $new_name;
            }
        }
    }

    // Validation
    if(empty($cat)) {
        echo "<script>alert('ကျေးဇူးပြု၍ Category ရွေးချယ်ပေးပါ'); window.history.back();</script>";
        exit();
    }

    // SQL Query (Column အသစ်များအားလုံး ပါဝင်သည်)
    $sql = "INSERT INTO contents (
                title, category, sub_category, location, description, 
                phone, schedule, 
                image_path, img_extra1, img_extra2, 
                breeding_system, requirements, health_safety, market_benefit
            ) VALUES (
                '$title', '$cat', '$sub_cat', '$loc', '$desc', 
                '$phone', '$schedule', 
                '{$image_names[0]}', '{$image_names[1]}', '{$image_names[2]}', 
                '$breeding_system', '$requirements', '$health_safety', '$market_benefit'
            )";

    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('အချက်အလက်နှင့် ပုံများ ထည့်သွင်းမှု အောင်မြင်ပါသည်'); window.location='admin.php';</script>";
    } else {
        echo "SQL Error: " . mysqli_error($conn);
    }
}
?>