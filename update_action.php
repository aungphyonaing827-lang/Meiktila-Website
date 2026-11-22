<?php
include 'db_connect.php';

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $cat = $_POST['category'];
    $loc = mysqli_real_escape_string($conn, $_POST['location']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    
    // Column အသစ်များအတွက် ပြင်ဆင်ခြင်း
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $schedule = mysqli_real_escape_string($conn, $_POST['schedule']);

    // ပုံအသစ်တင်မတင် စစ်ဆေးခြင်း
    if (!empty($_FILES['image']['name'])) {
        $img_name = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "Images/" . $img_name);
        
        // ပုံပါဝင်သော UPDATE Query
        $sql = "UPDATE contents SET title='$title', category='$cat', location='$loc', 
                description='$desc', phone='$phone', schedule='$schedule', 
                image_path='$img_name' WHERE id=$id";
    } else {
        // ပုံမပါသော UPDATE Query
        $sql = "UPDATE contents SET title='$title', category='$cat', location='$loc', 
                description='$desc', phone='$phone', schedule='$schedule' WHERE id=$id";
    }

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('ပြင်ဆင်မှု အောင်မြင်ပါသည်'); window.location='admin.php';</script>";
    } else {
        echo "Update Error: " . mysqli_error($conn);
    }
}
?>