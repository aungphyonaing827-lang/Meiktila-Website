<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="my">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Content | Meiktila Guide</title>
    <link rel="stylesheet" href="CSS/style.css">
    <style>
        body {
            font-family: 'Pyidaungsu', sans-serif;
            background-color: #f0f2f5;
            color: #333;
        }

        .form-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 40px;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #006a4e;
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            border-bottom: 3px solid #006a4e;
            padding-bottom: 10px;
        }

        label {
            display: block;
            margin-top: 18px;
            font-weight: bold;
            color: #444;
        }

        input[type="text"],
        input[type="file"],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 15px;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #006a4e;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 106, 78, 0.2);
        }

        /* Dynamic Sections */
        .special-section {
            background: #f9fbf9;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            margin-top: 20px;
            display: none;
            border-left: 5px solid #006a4e;
        }

        .hint {
            font-size: 13px;
            color: #006a4e;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .btn-submit {
            background: #006a4e;
            color: white;
            border: none;
            padding: 16px;
            cursor: pointer;
            width: 100%;
            font-size: 18px;
            font-weight: bold;
            border-radius: 8px;
            margin-top: 30px;
            transition: 0.3s ease;
        }

        .btn-submit:hover {
            background: #004d38;
            transform: translateY(-2px);
        }

        .cancel-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #888;
            text-decoration: none;
            font-size: 14px;
        }

        .cancel-link:hover {
            color: #d9534f;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h2><i class="fas fa-plus-circle"></i> Add New Content</h2>
        <form action="upload_action.php" method="POST" enctype="multipart/form-data">

            <label>အမည်/ခေါင်းစဉ် (Title):</label>
            <input type="text" name="title" placeholder="အမည် သို့မဟုတ် ခေါင်းစဉ် ရေးပါ" required>

            <label>ကဏ္ဍ (Category):</label>
            <select name="category" id="mainCategory" onchange="toggleFields()" required>
                <option value="">Category ကို ရွေးပါ</option>
                <option value="Agriculture">Agriculture (စိုက်ပျိုးရေး)</option>
                <option value="Livestock">Livestock (မွေးမြူရေး)</option>
                <option value="History">History (သမိုင်းကြောင်း)</option>
                <option value="Health">Health (Medical Hub)</option>
                <option value="Transportation">Transportation</option>
                <option value="Aviation">Aviation</option>
                <option value="Business">Business</option>
                <option value="Technology">Technology</option>
                <option value="Teaching">Teaching</option>
                <option value="PublicSchool">Public School</option>
                <option value="PrivateSchool">Private School</option>
                <option value="Landmark">Market</option>
                <option value="Gold Shop">Gold Shop</option>
                <option value="Cinema">Cinema</option>
                <option value="Accommodation">Accommodation</option>
                <option value="Restaurant">Restaurant</option>
                <option value="Beauty Salon">Beauty Salon</option>
                <option value="Gym">Gym</option>
                <option value="Showroom">Showroom</option>
                <option value="Food">Traditional Food</option>
                <option value="Culture">Traditional Culture</option>
            </select>

            <div id="subCategorySection" class="special-section">
                <label id="subLabel">အမျိုးအစား ခွဲခြားရန် (Sub-Category):</label>
                <select name="sub_category" id="subCategorySelect"></select>

                <div id="extraFields" style="display:none; margin-top:10px;">
                    <label id="extraLabel1">ဆက်သွယ်ရန်ဖုန်း:</label>
                    <input type="text" name="phone" placeholder="09-xxxxxxxxx">
                    <label id="extraLabel2">အချိန်ဇယား / ဖွင့်လှစ်ချိန်:</label>
                    <textarea name="timing" rows="2"></textarea>
                </div>
            </div>

            <div id="agriLiveSection" class="special-section">
                <p class="hint">* စိုက်ပျိုးရေး/မွေးမြူရေး ဆိုင်ရာ အသေးစိတ်များ</p>
                <label id="dynamicLabel1">စနစ်များ:</label>
                <textarea name="breeding_system" rows="3"></textarea>
                <label id="dynamicLabel2">လိုအပ်ချက်များ:</label>
                <textarea name="requirements" rows="3"></textarea>
                <label id="dynamicLabel3">ကျန်းမာရေးနှင့် ကာကွယ်ရေး:</label>
                <textarea name="health_safety" rows="3"></textarea>
                <label>ဈေးကွက်နှင့် အကျိုးအမြတ်:</label>
                <textarea name="market_benefit" rows="3"></textarea>
            </div>

            <label>တည်နေရာ (Location):</label>
            <input type="text" name="location" placeholder="လမ်းအမည်၊ ရပ်ကွက် သို့မဟုတ် မြို့နယ်" required>

            <label>အကြောင်းအရာ အပြည့်အစုံ (Full Description):</label>
            <textarea name="description" placeholder="အချက်အလက်များကို အသေးစိတ် ရေးသားရန်" rows="6" required></textarea>

            <label>ဓာတ်ပုံများ (Images):</label>
            <input type="file" name="images[]" accept="image/*" multiple required>
            <p style="font-size: 12px; color: #d9534f;">* အနည်းဆုံး (၁) ပုံ တင်ပေးရန် လိုအပ်ပါသည်။</p>

            <button type="submit" name="submit" class="btn-submit">Save Content</button>
            <a href="admin.php" class="cancel-link">Cancel and Go Back</a>
        </form>
    </div>

    <script>
        function toggleFields() {
            var category = document.getElementById("mainCategory").value;
            var subSection = document.getElementById("subCategorySection");
            var agriLiveSection = document.getElementById("agriLiveSection");
            var extraFields = document.getElementById("extraFields");
            var subSelect = document.getElementById("subCategorySelect");
            var subLabel = document.getElementById("subLabel");

            // Hide everything first
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
            } else if (category === "Health") {
                subSection.style.display = "block";
                subLabel.innerText = "ကျန်းမာရေးဝန်ဆောင်မှု အမျိုးအစား:";
                subSelect.innerHTML = `<option value="Hospital">ဆေးရုံ</option><option value="Clinic">ဆေးခန်း</option><option value="Laboratory">ဓာတ်ခွဲခန်း</option>`;
            } else if (category === "Transportation") {
                subSection.style.display = "block";
                extraFields.style.display = "block";
                subLabel.innerText = "သယ်ယူပို့ဆောင်ရေး အမျိုးအစား:";
                subSelect.innerHTML = `<option value="Road">Road</option><option value="Rail">Railway</option><option value="Air">Air</option><option value="Urban">Urban</option>`;

            } else if (category === "Agriculture" || category === "Livestock") {
                agriLiveSection.style.display = "block";
                var d1 = document.getElementById("dynamicLabel1");
                var d2 = document.getElementById("dynamicLabel2");
                var d3 = document.getElementById("dynamicLabel3");

                if (category === "Agriculture") {
                    d1.innerText = "စိုက်ပျိုးနည်းစနစ်များ:";
                    d2.innerText = "စိုက်ပျိုးရန်လိုအပ်ချက်များ:";
                    d3.innerText = "ပိုးမွှားကာကွယ်ရေး:";
                } else {
                    d1.innerText = "မွေးမြူရေးစနစ်များ:";
                    d2.innerText = "မွေးမြူရန်လိုအပ်ချက်များ:";
                    d3.innerText = "ရောဂါကာကွယ်ရေး:";
                }
            } else if (category === "PublicSchool" || category === "PrivateSchool" || category === "Teaching") {
                subSection.style.display = "block";
                subLabel.innerText = "ပညာရေးအဆင့်အတန်း:";
                subSelect.innerHTML = `<option value="Primary">မူလတန်း</option><option value="Middle">အလယ်တန်း</option><option value="High">အထက်တန်း</option><option value="University">တက္ကသိုလ်/ကောလိပ်</option>`;
            }
            // For other categories like Gold Shop, Restaurant, Gym etc. show extra info (phone/time)
            else if (["Gold Shop", "Cinema", "Accommodation", "Restaurant", "Beauty Salon", "Gym", "Showroom", "Business", "Landmark"].includes(category)) {
                subSection.style.display = "block";
                extraFields.style.display = "block";
                subLabel.innerText = "အမျိုးအစား:";
                subSelect.innerHTML = `<option value="Premium">Premium</option><option value="Standard">Standard</option><option value="Local">Local</option>`;
            }
        }
    </script>

</body>

</html>