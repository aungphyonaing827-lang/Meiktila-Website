<?php
session_start();
include 'db_connect.php';

// 1. Authentication Check
if (!isset($_SESSION['username'])) { 
    header("Location: login.php"); 
    exit(); 
}

// 2. Fetch Existing Data
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM contents WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        die("<div style='text-align:center; padding:50px;'>Data မရှိပါ သို့မဟုတ် ဖျက်ပြီးဖြစ်နေပါမည်။ <a href='admin.php'>Back</a></div>");
    }
} else {
    header("Location: admin.php");
    exit();
}

// 3. Update Logic
if (isset($_POST['update_data'])) {
    $id = $_POST['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = $_POST['category'];
    $sub_category = isset($_POST['sub_category']) ? mysqli_real_escape_string($conn, $_POST['sub_category']) : '';
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $schedule = mysqli_real_escape_string($conn, $_POST['schedule']);

    // Agriculture/Livestock specific fields
    $breeding_system = mysqli_real_escape_string($conn, $_POST['breeding_system']);
    $requirements = mysqli_real_escape_string($conn, $_POST['requirements']);
    $health_safety = mysqli_real_escape_string($conn, $_POST['health_safety']);
    $market_benefit = mysqli_real_escape_string($conn, $_POST['market_benefit']);

    // Image Upload Handling
    $img_sql = "";
    $upload_dir = "Images/";

    // Logic for Main Image, Extra 1, and Extra 2
    $files_to_check = [
        'image' => 'image_path',
        'img_extra1' => 'img_extra1',
        'img_extra2' => 'img_extra2'
    ];

    foreach ($files_to_check as $input_name => $db_field) {
        if (!empty($_FILES[$input_name]['name'])) {
            $new_name = time() . "_" . $input_name . "_" . $_FILES[$input_name]['name'];
            if (move_uploaded_file($_FILES[$input_name]['tmp_name'], $upload_dir . $new_name)) {
                $img_sql .= ", $db_field='$new_name'";
            }
        }
    }

    $sql = "UPDATE contents SET 
            title='$title', 
            category='$category', 
            sub_category='$sub_category',
            location='$location', 
            description='$description', 
            phone='$phone', 
            schedule='$schedule',
            breeding_system='$breeding_system',
            requirements='$requirements',
            health_safety='$health_safety',
            market_benefit='$market_benefit'
            $img_sql 
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('အောင်မြင်စွာ ပြင်ဆင်ပြီးပါပြီ!'); window.location='admin.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Content | Meiktila Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Pyidaungsu', sans-serif; background-color: #f0f2f5; color: #333; margin: 0; padding: 20px; }
        .form-container { max-width: 850px; margin: 20px auto; padding: 40px; border-radius: 12px; background: #fff; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        h2 { color: #006a4e; text-align: center; margin-bottom: 30px; font-size: 24px; border-bottom: 3px solid #006a4e; padding-bottom: 10px; }
        
        label { display: block; margin-top: 18px; font-weight: bold; color: #444; }
        input[type="text"], input[type="file"], select, textarea { width: 100%; padding: 12px; margin: 8px 0; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; font-size: 15px; }
        
        /* Dynamic Sections Styled like add_content.php */
        .special-section { background: #f9fbf9; padding: 20px; border-radius: 8px; border: 1px solid #e0e0e0; margin-top: 20px; display: none; border-left: 5px solid #006a4e; }
        .hint { font-size: 13px; color: #006a4e; margin-bottom: 10px; font-weight: bold; }

        /* Image Preview Styles */
        .image-preview-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 10px; }
        .img-box { border: 1px solid #ddd; padding: 10px; border-radius: 8px; text-align: center; background: #fafafa; }
        .img-box img { width: 100%; height: 120px; object-fit: cover; border-radius: 4px; margin-bottom: 8px; }

        .btn-submit { background: #006a4e; color: white; border: none; padding: 16px; cursor: pointer; width: 100%; font-size: 18px; font-weight: bold; border-radius: 8px; margin-top: 30px; transition: 0.3s ease; }
        .btn-submit:hover { background: #004d38; transform: translateY(-2px); }
        .cancel-link { display: block; text-align: center; margin-top: 20px; color: #888; text-decoration: none; }
        .cancel-link:hover { color: #d9534f; }
    </style>
</head>
<body>

<div class="form-container">
    <h2><i class="fas fa-edit"></i> Edit Content Details</h2>
    
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

        <label>အမည်/ခေါင်းစဉ် (Title):</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($data['title']); ?>" required>

        <label>ကဏ္ဍ (Category):</label>
        <select name="category" id="mainCategory" onchange="toggleFields()" required>
            <?php 
            $categories = [
                "Agriculture" => "Agriculture (စိုက်ပျိုးရေး)",
                "Livestock" => "Livestock (မွေးမြူရေး)",
                "History" => "History (သမိုင်းကြောင်း)",
                "Health" => "Health (Medical Hub)",
                "Transportation" => "Transportation",
                "Aviation" => "Aviation",
                "Business" => "Business",
                "Technology" => "Technology",
                "Teaching" => "Teaching",
                "PublicSchool" => "Public School",
                "PrivateSchool" => "Private School",
                "Landmark" => "Market",
                "Gold Shop" => "Gold Shop",
                "Cinema" => "Cinema",
                "Accommodation" => "Accommodation",
                "Restaurant" => "Restaurant",
                "Beauty Salon" => "Beauty Salon",
                "Gym" => "Gym",
                "Showroom" => "Showroom",
                "Food" => "Traditional Food",
                "Culture" => "Traditional Culture"
            ];
            foreach($categories as $val => $label) {
                $selected = ($data['category'] == $val) ? "selected" : "";
                echo "<option value='$val' $selected>$label</option>";
            }
            ?>
        </select>

        <div id="subCategorySection" class="special-section">
            <label id="subLabel">အမျိုးအစား ခွဲခြားရန် (Sub-Category):</label>
            <select name="sub_category" id="subCategorySelect"></select>
            
            <div id="extraFields" style="display:none; margin-top:10px;">
                <label>ဆက်သွယ်ရန်ဖုန်း:</label>
                <input type="text" name="phone" value="<?php echo htmlspecialchars($data['phone']); ?>" placeholder="09-xxxxxxxxx">
                <label>အချိန်ဇယား / ဖွင့်လှစ်ချိန်:</label>
                <textarea name="schedule" rows="2"><?php echo htmlspecialchars($data['schedule']); ?></textarea>
            </div>
        </div>

        <div id="agriLiveSection" class="special-section">
            <p class="hint">* စိုက်ပျိုးရေး/မွေးမြူရေး ဆိုင်ရာ အသေးစိတ်များ</p>
            <label id="dynamicLabel1">စနစ်များ:</label>
            <textarea name="breeding_system" rows="3"><?php echo htmlspecialchars($data['breeding_system']); ?></textarea>
            <label id="dynamicLabel2">လိုအပ်ချက်များ:</label>
            <textarea name="requirements" rows="3"><?php echo htmlspecialchars($data['requirements']); ?></textarea>
            <label id="dynamicLabel3">ကျန်းမာရေးနှင့် ကာကွယ်ရေး:</label>
            <textarea name="health_safety" rows="3"><?php echo htmlspecialchars($data['health_safety']); ?></textarea>
            <label>ဈေးကွက်နှင့် အကျိုးအမြတ်:</label>
            <textarea name="market_benefit" rows="3"><?php echo htmlspecialchars($data['market_benefit']); ?></textarea>
        </div>

        <label>တည်နေရာ (Location):</label>
        <input type="text" name="location" value="<?php echo htmlspecialchars($data['location']); ?>" required>

        <label>အကြောင်းအရာ အပြည့်အစုံ (Full Description):</label>
        <textarea name="description" rows="8" required><?php echo htmlspecialchars($data['description']); ?></textarea>

        <label>ဓာတ်ပုံများ စီမံရန် (Images):</label>
        <div class="image-preview-grid">
            <div class="img-box">
                <span class="hint">ပင်မဓာတ်ပုံ</span>
                <img src="Images/<?php echo $data['image_path']; ?>" onerror="this.src='Images/default.jpg'">
                <input type="file" name="image" accept="image/*">
            </div>
            <div class="img-box">
                <span class="hint">အပိုဓာတ်ပုံ ၁</span>
                <img src="Images/<?php echo !empty($data['img_extra1']) ? $data['img_extra1'] : 'default.jpg'; ?>">
                <input type="file" name="img_extra1" accept="image/*">
            </div>
            <div class="img-box">
                <span class="hint">အပိုဓာတ်ပုံ ၂</span>
                <img src="Images/<?php echo !empty($data['img_extra2']) ? $data['img_extra2'] : 'default.jpg'; ?>">
                <input type="file" name="img_extra2" accept="image/*">
            </div>
        </div>
        <p style="font-size: 12px; color: #777; margin-top:10px;">* ဓာတ်ပုံအသစ် မရွေးချယ်ပါက ယခင်ပုံဟောင်းကိုသာ ဆက်လက်အသုံးပြုပါမည်။</p>

        <button type="submit" name="update_data" class="btn-submit">Update Content</button>
        <a href="admin.php" class="cancel-link">Cancel and Go Back</a>
    </form>
</div>

<script>
// Logic to pre-select the sub-category after the list is generated
var savedSubCategory = "<?php echo $data['sub_category']; ?>";

function toggleFields() {
    var category = document.getElementById("mainCategory").value;
    var subSection = document.getElementById("subCategorySection");
    var agriLiveSection = document.getElementById("agriLiveSection");
    var extraFields = document.getElementById("extraFields");
    var subSelect = document.getElementById("subCategorySelect");
    var subLabel = document.getElementById("subLabel");

    subSection.style.display = "none";
    agriLiveSection.style.display = "none";
    extraFields.style.display = "none";
    subSelect.innerHTML = "";

    if (category === "History") {
        subSection.style.display = "block";
        subLabel.innerText = "သမိုင်းဝင်နေရာ အမျိုးအစား:";
        subSelect.innerHTML = `
            <option value="ဖောင်တော်ဦးစေတီတော်နှင့် တန်ခိုးကြီးစေတီတော်များ">စေတီပုထိုးများ</option>
            <option value="မိတ္ထီလာကန်နှင့် မင်းဆက်များ">မိတ္ထီလာကန်နှင့် မင်းဆက်များ</option>
            <option value="သိမ်ကိုးသိမ်">သိမ်ကိုးသိမ်</option>
            <option value="အခြား">အခြား</option>`;
    } 
    else if (category === "Health") {
        subSection.style.display = "block";
        subLabel.innerText = "ကျန်းမာရေးဝန်ဆောင်မှု အမျိုးအစား:";
        subSelect.innerHTML = `<option value="Hospital">ဆေးရုံ</option><option value="Clinic">ဆေးခန်း</option><option value="Laboratory">ဓာတ်ခွဲခန်း</option>`;
    }
    else if (category === "Transportation") {
        subSection.style.display = "block";
        extraFields.style.display = "block";
        subLabel.innerText = "သယ်ယူပို့ဆောင်ရေး အမျိုးအစား:";
        subSelect.innerHTML = `<option value="Road">Road</option><option value="Rail">Railway</option><option value="Air">Air</option><option value="Urban">Urban</option>`;
    }
    else if (category === "Agriculture" || category === "Livestock") {
        agriLiveSection.style.display = "block";
        var d1 = document.getElementById("dynamicLabel1");
        var d2 = document.getElementById("dynamicLabel2");
        var d3 = document.getElementById("dynamicLabel3");
        
        if(category === "Agriculture") {
            d1.innerText = "စိုက်ပျိုးနည်းစနစ်များ:";
            d2.innerText = "စိုက်ပျိုးရန်လိုအပ်ချက်များ:";
            d3.innerText = "ပိုးမွှားကာကွယ်ရေး:";
        } else {
            d1.innerText = "မွေးမြူရေးစနစ်များ:";
            d2.innerText = "မွေးမြူရန်လိုအပ်ချက်များ:";
            d3.innerText = "ရောဂါကာကွယ်ရေး:";
        }
    }
    else if (["PublicSchool", "PrivateSchool", "Teaching"].includes(category)) {
        subSection.style.display = "block";
        subLabel.innerText = "ပညာရေးအဆင့်အတန်း:";
        subSelect.innerHTML = `<option value="Primary">မူလတန်း</option><option value="Middle">အလယ်တန်း</option><option value="High">အထက်တန်း</option><option value="University">တက္ကသိုလ်/ကောလိပ်</option>`;
    }
    else if (["Gold Shop", "Cinema", "Accommodation", "Restaurant", "Beauty Salon", "Gym", "Showroom", "Business", "Landmark"].includes(category)) {
        subSection.style.display = "block";
        extraFields.style.display = "block";
        subLabel.innerText = "အမျိုးအစား:";
        subSelect.innerHTML = `<option value="Premium">Premium</option><option value="Standard">Standard</option><option value="Local">Local</option>`;
    }

    // Set the saved value if it matches an option
    if(savedSubCategory) {
        subSelect.value = savedSubCategory;
    }
}

// Run on page load
window.onload = toggleFields;
</script>

</body>
</html>