<?php 
session_start();
include 'db_connect.php'; 

// Database မှ Health data များကို ဆွဲထုတ်ခြင်း
$query = "SELECT * FROM contents WHERE category = 'Health' ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Hub | Meiktila</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/style.css"> 

    <style>
        :root { 
            --primary: #166534; /* Green for Health */
            --accent: #22c55e;
            --bg: #f0fdf4;
            --white: #ffffff;
            --shadow: 0 10px 25px rgba(0,0,0,0.08);
            --radius: 20px;
        }
        
        body { background-color: var(--bg); font-family: 'Pyidaungsu', sans-serif; margin: 0; }
        
        /* Hero Section */
        .hero-section { 
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('Images/hospital1.jpg');
            background-size: cover; background-position: center;
            height: 300px; display: flex; flex-direction: column; align-items: center; justify-content: center;
            text-align: center; color: white;
        }
        .hero-section h1 { font-size: 2.8rem; margin-bottom: 10px; }

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
        .health-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 25px; }
        .card {
            background: var(--white); border-radius: var(--radius); overflow: hidden;
            box-shadow: var(--shadow); transition: 0.3s; display: flex; flex-direction: column;
            position: relative; border: 1px solid #e2e8f0;
        }
        .card:hover { transform: translateY(-8px); border-color: var(--accent); }
        .card-img { width: 100%; height: 200px; object-fit: cover; }
        .card-content { padding: 20px; flex-grow: 1; }
        .card-content h3 { margin: 0 0 10px; color: var(--primary); font-size: 1.3rem; }
        
        .badge {
            background: var(--accent); color: white; padding: 4px 12px; 
            border-radius: 20px; font-size: 0.8rem; position: absolute; top: 15px; right: 15px;
            z-index: 5; font-weight: bold;
        }

        .read-more-btn {
            background: #dcfce7; color: var(--primary); border: 1px solid var(--accent); padding: 10px 15px;
            border-radius: 10px; width: 100%; margin-top: 15px; font-weight: bold;
            cursor: pointer; transition: 0.3s; display: flex; justify-content: center; gap: 8px;
        }
        .read-more-btn:hover { background: var(--primary); color: white; }

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
        .close-btn { position: absolute; top: 15px; right: 20px; font-size: 1.8rem; color: #666; cursor: pointer; z-index: 10; }
        .modal-body { padding: 30px; }

        .no-data { grid-column: 1 / -1; text-align: center; padding: 50px; color: #888; }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<section class="hero-section">
    <h1>Medical Hub</h1>
    <p>မိတ္ထီလာမြို့ရှိ ဆေးရုံ၊ ဆေးခန်းများနှင့် ကျန်းမာရေးဝန်ဆောင်မှုများ</p>
</section>

<div class="container">
    <div class="search-wrapper">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchBar" placeholder="Search by hospital and specialist name...">
        </div>
    </div>

    <div class="filter-container">
        <button class="filter-pill active" onclick="filterHealth('all', this)">အားလုံး</button>
        <button class="filter-pill" onclick="filterHealth('Hospital', this)">ဆေးရုံကြီးများ</button>
        <button class="filter-pill" onclick="filterHealth('Clinic', this)">အထူးကုဆေးခန်းများ</button>
        <button class="filter-pill" onclick="filterHealth('Laboratory', this)">ဓာတ်ခွဲခန်းများ</button>
    </div>

    <div class="health-grid" id="healthGrid">
        <?php 
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $json_data = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                $sub_cat = $row['sub_category'] ?: 'General';
        ?>
            <div class="card health-card" data-category="<?php echo $sub_cat; ?>">
                <div class="badge"><?php echo $sub_cat; ?></div>
                <img src="Images/<?php echo $row['image_path'] ?: 'default-health.jpg'; ?>" class="card-img" onerror="this.src='Images/default.jpg'">
                <div class="card-content">
                    <h3><?php echo $row['title']; ?></h3>
                    <p style="font-size: 0.9rem; color:#666;"><i class="fas fa-map-marker-alt"></i> <?php echo $row['location']; ?></p>
                    
                    <button class="read-more-btn" onclick='openModal(<?php echo $json_data; ?>)'>
                        View Details <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        <?php 
            }
        } else {
            echo '<div class="no-data">ရှာဖွေမှုနှင့် ကိုက်ညီသော အချက်အလက် မရှိသေးပါ။</div>';
        }
        ?>
    </div>
</div>

<div id="detailModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <img id="mImg" src="" style="width:100%; height:250px; object-fit:cover;">
        <div class="modal-body">
            <h2 id="mTitle" style="color:var(--primary);"></h2>
            <hr style="border:0.5px solid #eee; margin:15px 0;">
            <p><strong><i class="fas fa-hospital"></i> အမျိုးအစား:</strong> <span id="mCat"></span></p>
            <p><strong><i class="fas fa-map-marker-alt"></i> တည်နေရာ:</strong> <span id="mLoc"></span></p>
            <p><strong><i class="fas fa-phone-alt"></i> ဆက်သွယ်ရန်:</strong> <span id="mPhone"></span></p>
            
            <div style="background:#f9f9f9; padding:15px; border-radius:15px; margin-top:15px;">
                <p><strong>ဝန်ဆောင်မှုများ:</strong></p>
                <p id="mDesc" style="color:#555; line-height:1.6; white-space: pre-line;"></p>
            </div>
        </div>
    </div>
</div>

<script>
    // Filtering Logic
    function filterHealth(category, btn) {
        document.querySelectorAll('.filter-pill').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        let cards = document.querySelectorAll('.health-card');
        cards.forEach(card => {
            if (category === 'all' || card.getAttribute('data-category') === category) {
                card.style.display = "flex";
            } else {
                card.style.display = "none";
            }
        });
    }

    // Search Logic
    document.getElementById('searchBar').addEventListener('input', function() {
        let searchValue = this.value.toLowerCase().trim();
        let cards = document.querySelectorAll('.health-card');
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
        document.getElementById('mCat').innerText = data.sub_category || 'General Health';
        document.getElementById('mDesc').innerText = data.description;
        document.getElementById('mImg').src = "Images/" + (data.image_path || 'default.jpg');
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