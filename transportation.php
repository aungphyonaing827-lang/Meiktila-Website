<?php 
session_start();
include 'db_connect.php'; 

// Database မှ Transportation data များကို ဆွဲထုတ်ခြင်း
$query = "SELECT * FROM contents WHERE category = 'Transportation' ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transportation Hub | Meiktila</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/style.css"> 

    <style>
        :root { 
            --primary: #006a4e; 
            --accent: #27ae60;
            --bg: #f8faf9;
            --white: #ffffff;
            --shadow: 0 10px 25px rgba(0,0,0,0.08);
            --radius: 20px;
        }
        
        body { background-color: var(--bg); font-family: 'Pyidaungsu', sans-serif; margin: 0; }
        
        /* Hero Section */
        .hero-section { 
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('Images/meiktilaBusStation.jpg');
            background-size: cover; background-position: center;
            height: 350px; display: flex; flex-direction: column; align-items: center; justify-content: center;
            text-align: center; color: white;
        }
        .hero-section h1 { font-size: 3rem; margin-bottom: 10px; }

        .container { max-width: 1200px; margin: 0 auto; padding: 20px 20px 60px; }

        /* Search Box */
        .search-wrapper { margin-top: -35px; display: flex; justify-content: center; margin-bottom: 30px; }
        .search-box {
            background: var(--white); width: 100%; max-width: 600px; padding: 12px 25px; 
            border-radius: 50px; box-shadow: var(--shadow); display: flex; align-items: center;
        }
        .search-box input { border: none; outline: none; width: 100%; font-size: 1rem; padding-left: 15px; }

        /* Filter Buttons */
        .filter-container { display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; margin-bottom: 40px; }
        .filter-pill {
            padding: 10px 25px; border-radius: 30px; background: #e0e0e0; color: #555;
            border: none; font-weight: 600; cursor: pointer; transition: 0.3s;
        }
        .filter-pill.active { background: var(--primary); color: white; }

        /* Grid & Cards */
        .transport-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 25px; }
        .card {
            background: var(--white); border-radius: var(--radius); overflow: hidden;
            box-shadow: var(--shadow); transition: 0.3s; display: flex; flex-direction: column;
            position: relative;
        }
        .card:hover { transform: translateY(-8px); }
        .card-img { width: 100%; height: 200px; object-fit: cover; }
        .card-content { padding: 20px; flex-grow: 1; }
        .card-content h3 { margin: 0 0 10px; color: var(--primary); font-size: 1.3rem; }
        
        .badge {
            background: var(--accent); color: white; padding: 4px 12px; 
            border-radius: 20px; font-size: 0.8rem; position: absolute; top: 15px; right: 15px;
            z-index: 5;
        }

        /* Read More Button */
        .read-more-btn {
            background: var(--primary); color: white; border: none; padding: 10px 15px;
            border-radius: 10px; width: 100%; margin-top: 15px; font-weight: bold;
            cursor: pointer; transition: 0.3s; display: flex; justify-content: center; gap: 8px;
        }
        .read-more-btn:hover { background: var(--accent); }

        /* Modal Styles */
        .modal { 
            display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; 
            background: rgba(0,0,0,0.7); backdrop-filter: blur(5px); justify-content: center; align-items: center;
        }
        .modal-content { 
            background: white; border-radius: 25px; width: 90%; max-width: 600px; 
            max-height: 85vh; overflow-y: auto; position: relative; animation: slideDown 0.4s ease;
        }
        @keyframes slideDown { from { transform: translateY(-50px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .close-btn { position: absolute; top: 15px; right: 20px; font-size: 1.8rem; color: #666; cursor: pointer; }
        .modal-body { padding: 30px; }

        .no-data { grid-column: 1 / -1; text-align: center; padding: 50px; color: #888; display: none; }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<section class="hero-section">
    <h1>Transportation Hub</h1>
    <p>မိတ္ထီလာမြို့၏ စနစ်ကျသော သွားလာရေးနှင့် ခရီးစဉ်လမ်းညွှန်များ</p>
</section>

<div class="container">
    <div class="search-wrapper">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchBar" placeholder="Enter the name of the bus line or city you want to search for ...">
        </div>
    </div>

    <div class="filter-container">
        <button class="filter-pill active" onclick="filterTransport('all', this)">အားလုံး</button>
        <button class="filter-pill" onclick="filterTransport('Road', this)">ကုန်းလမ်း</button>
        <button class="filter-pill" onclick="filterTransport('Rail', this)">မီးရထား</button>
        <button class="filter-pill" onclick="filterTransport('Air', this)">လေကြောင်း</button>
        <button class="filter-pill" onclick="filterTransport('Urban', this)">မြို့တွင်း</button>
    </div>

    <div class="transport-grid" id="transportGrid">
        
        <div class="card transport-card" data-category="Road">
            <div class="badge">လမ်းညွှန်</div>
            <div class="card-content">
                <h3>အဓိက ကုန်းလမ်းမကြီးများ</h3>
                <ul style="font-size: 0.9rem; color: #555; padding-left: 20px;">
                    <li>ရန်ကုန်-မန္တလေး လမ်းဟောင်း (မြို့လယ်ဖြတ်)</li>
                    <li>မိတ္ထီလာ-တောင်ကြီးလမ်း (ရှမ်းတောင်အဓိကလမ်း)</li>
                    <li>မိတ္ထီလာ-မြင်းခြံ-ပုဂံလမ်း</li>
                    <li>အမြန်လမ်း (သပြေဝ Interchange မှတစ်ဆင့်)</li>
                </ul>
                <p style="font-size: 0.9rem; color: #555;">ရန်ကုန်-မန္တလေး လမ်းဟောင်း၊ မိတ္ထီလာ-တောင်ကြီးလမ်း နှင့် အမြန်လမ်းတို့၏ ဗဟိုချက်ဖြစ်သည်။</p>
            </div>
        </div>


        <div class="card transport-card" data-category="Rail">
            <div class="badge">လမ်းညွှန်</div>
            <div class="card-content">
                <h3>မီးရထားလမ်း</h3>
                <p style="font-size: 0.9rem; color: #555;">သာစည်-မိတ္ထီလာ-မြင့်ခြံ လမ်းပိုင်း: မိတ္ထီလာဘူတာဟာ သာစည်ဘူတာကြီး (ပင်မလမ်းဆုံ) နဲ့ ချိတ်ဆက်ထားတာကြောင့် ရန်ကုန်-မန္တလေး ရထားလမ်းပိုင်းကို အလွယ်တကူ ကူးပြောင်းစီးနင်းနိုင်ပါတယ်။
​ကုန်စည်စီးဆင်းမှုနဲ့ ဒေသခံခရီးသည်တွေအတွက် အရေးပါတဲ့ လမ်းကြောင်းတစ်ခု ဖြစ်ပါတယ်။

 </p>
            </div>
        </div>

        <div class="card transport-card" data-category="Air">
            <div class="badge">လမ်းညွှန်</div>
            <div class="card-content">
                <h3>လေကြောင်း</h3>
                <p style="font-size: 0.9rem; color: #555;">လေကြောင်းပို့ဆောင်ရေး
​မိတ္ထီလာမြို့မှာ ရှမ်းတဲ (Shantel) လေတပ်စခန်းဌာနချုပ် ရှိပါတယ်။ သို့သော်လည်း -
​ဒါဟာ အဓိကအားဖြင့် စစ်ဘက်ဆိုင်ရာ လေဆိပ်ဖြစ်ပြီး အများပြည်သူသုံး အရပ်ဘက်လေကြောင်းလိုင်းများ ပုံမှန်ဆင်းသက်ခြင်း မရှိပါ။
​အရပ်ဘက်လေကြောင်း အသုံးပြုလိုသူတွေအနေနဲ့ မိတ္ထီလာကနေ (၂) နာရီခန့် ကားစီးရတဲ့ တံတားဦး အပြည်ပြည်ဆိုင်ရာလေဆိပ် (မန္တလေး) ကို အဓိက အသုံးပြုကြပါတယ်။

</p>
            </div>
        </div>

        <div class="card transport-card" data-category="Urban">
            <div class="badge">လမ်းညွှန်</div>
            <div class="card-content">
                <h3>မြို့တွင်းသွားလာရေး</h3>
                <p style="font-size: 0.9rem; color: #555;">သုံးဘီးဆိုင်ကယ်နဲ့ ဆိုင်ကယ်တက္ကစီ: မြို့တွင်း ခရီးတို သွားလာရေးအတွက် အသုံးအများဆုံး ဖြစ်ပါတယ်။
​Light Truck (လိုက်ထရပ်): အနီးနားက ကျေးရွာတွေနဲ့ မြို့တွေကို ပြေးဆွဲတဲ့ ခရီးသည်တင်ယာဉ်ငယ်များ ရှိပါတယ်။
​အနှစ်ချုပ်အနေနဲ့: မိတ္ထီလာဟာ မြန်မာပြည်အနှံ့ကို သွားလာနိုင်တဲ့ "အချက်အချာဗဟို" ဖြစ်တာကြောင့် ကုန်စည်စီးဆင်းမှု မြန်ဆန်ပြီး သွားလာရေး အလွန်လွယ်ကူတဲ့ မြို့တစ်မြို့ ဖြစ်ပါတယ်။
​မိတ္ထီလာနဲ့ မြန်မာနိုင်ငံတဝှမ်းမှာရှိတဲ့ Tuk Tuk (အိုဝေ/သုံးဘီး) တွေဟာ လူတန်းစားမရွေး အသုံးပြုကြတဲ့ "ပြည်သူ့ယာဉ်" လို့တောင် ပြောလို့ရပါတယ်။
သုံးဘီးဆိုင်ကယ် (Tuk Tuk): မြို့တွင်း အတိုအထွာသွားလာရန် အသုံးအများဆုံးဖြစ်သည်။ ခရီးစဉ်အကွာအဝေးပေါ်မူတည်၍ ဈေးနှုန်း ကွာခြားနိုင်ပါသည်။
ဘုရားဖူးများနှင့် ခရီးသွားများ: မိတ္ထီလာ ဖောင်တော်ဦးစေတီ သို့မဟုတ် ကန်ပတ်လမ်းတဝိုက် လည်ပတ်ချင်တဲ့ ခရီးသွားတွေက လေတိုက်ခံပြီး မြို့အလှကြည့်လို့ရတဲ့ အိုဝေကို သဘောကျကြပါတယ်။
မိတ္ထီလာကို ရောက်တဲ့အခါ အိုဝေငှားစီးမယ်ဆိုရင် "ဘယ်နေရာကို ဘယ်လောက်လဲ" လို့ အရင်မေးပြီး ဈေးဆစ်ကြည့်ဖို့ မမေ့ပါနဲ့ဦး။
</p>
            </div>
        </div>

        <?php 
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $json_data = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
        ?>
            <div class="card transport-card" data-category="<?php echo $row['sub_category']; ?>">
                <div class="badge">ယာဉ်လိုင်း</div>
                <img src="Images/<?php echo $row['image_path'] ?: 'default-bus.jpg'; ?>" class="card-img">
                <div class="card-content">
                    <h3><?php echo $row['title']; ?></h3>
                    <p style="font-size: 0.9rem; color:#666;"><i class="fas fa-map-marker-alt"></i> <?php echo $row['location']; ?></p>
                    
                    <button class="read-more-btn" onclick='openModal(<?php echo $json_data; ?>)'>
                        Read More <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        <?php 
            }
        } 
        ?>
        
        <div id="noDataMessage" class="no-data">ရှာဖွေမှုနှင့် ကိုက်ညီသော အချက်အလက် မရှိပါ။</div>
    </div>
</div>

<div id="detailModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <img id="mImg" src="" style="width:100%; height:250px; object-fit:cover;">
        <div class="modal-body">
            <h2 id="mTitle" style="color:var(--primary);"></h2>
            <hr style="border:0.5px solid #eee; margin:15px 0;">
            <p><strong><i class="fas fa-map-marker-alt"></i> လမ်းကြောင်း:</strong> <span id="mLoc"></span></p>
            <p><strong><i class="fas fa-phone-alt"></i> ဖုန်း:</strong> <span id="mPhone"></span></p>
            <p><strong><i class="fas fa-clock"></i> အချိန်စာရင်း:</strong> <span id="mSchedule"></span></p>
            <div style="background:#f9f9f9; padding:15px; border-radius:15px; margin-top:15px;">
                <p><strong>အသေးစိတ်အချက်အလက်:</strong></p>
                <p id="mDesc" style="color:#555; line-height:1.6;"></p>
            </div>
        </div>
    </div>
</div>

<script>
    // Filtering Logic
    function filterTransport(category, btn) {
        document.querySelectorAll('.filter-pill').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        let cards = document.querySelectorAll('.transport-card');
        let visibleCount = 0;

        cards.forEach(card => {
            if (category === 'all' || card.getAttribute('data-category') === category) {
                card.style.display = "flex";
                visibleCount++;
            } else {
                card.style.display = "none";
            }
        });
        document.getElementById('noDataMessage').style.display = (visibleCount === 0) ? "block" : "none";
    }

    // Search Logic
    document.getElementById('searchBar').addEventListener('input', function() {
        let searchValue = this.value.toLowerCase().trim();
        let cards = document.querySelectorAll('.transport-card');
        cards.forEach(card => {
            let title = card.querySelector('h3').innerText.toLowerCase();
            card.style.display = title.includes(searchValue) ? "flex" : "none";
        });
    });

    // Modal Functions
    function openModal(data) {
        document.getElementById('mTitle').innerText = data.title;
        document.getElementById('mLoc').innerText = data.location;
        document.getElementById('mPhone').innerText = data.phone || 'မရှိပါ';
        document.getElementById('mSchedule').innerText = data.schedule || 'မရှိပါ';
        document.getElementById('mDesc').innerText = data.description;
        document.getElementById('mImg').src = "Images/" + (data.image_path || 'default-bus.jpg');
        document.getElementById('detailModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('detailModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('detailModal')) closeModal();
    }
</script>

</body>
</html>