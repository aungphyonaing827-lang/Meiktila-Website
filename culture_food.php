<?php 
session_start();
include 'db_connect.php'; 
header('Content-Type: text/html; charset=utf-8');

$query = "SELECT * FROM contents WHERE category IN ('Culture', 'Food') ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Culture & Food | Meiktila Guide</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Padauk:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS/style.css"> 
    <style>
        :root {
            --primary-teal: #00796b; 
            --bg-soft: #f4f7f6;
            --white: #ffffff;
            --text-dark: #2c3e50;
            --transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        /* --- FONT FIXES (KEEPING THESE) --- */
        * {
            margin: 0; padding: 0; box-sizing: border-box;
            font-family: 'Pyidaungsu', 'Padauk', 'Myanmar Sans Serif', sans-serif;
            letter-spacing: normal !important; 
        }

        body {
            background-color: var(--bg-soft);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* --- ANIMATION KEYFRAMES --- */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes modalBounce {
            0% { transform: scale(0.8); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        /* --- Hero Section --- */
        .hero {
            height: 450px;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('Images/photo_2026-02-18_19-55-44.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: var(--white);
            padding: 0 20px;
        }

        .hero h1 {
            font-size: 3.5rem;
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .hero p {
            font-size: 1.2rem;
            margin: 15px 0 30px;
            max-width: 800px;
            line-height: 1.8;
            animation: fadeInUp 1s ease-out forwards;
        }

        .search-container {
            width: 100%;
            max-width: 600px;
            position: relative;
            animation: fadeInUp 1.2s ease-out forwards;
        }

        .search-container input {
            width: 100%;
            padding: 18px 25px 18px 60px;
            border-radius: 50px;
            border: none;
            outline: none;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            transition: var(--transition);
        }

        .search-container input:focus {
            transform: scale(1.02);
            box-shadow: 0 15px 30px rgba(0,0,0,0.25);
        }

        /* --- Filter Tabs --- */
        .filter-section {
            padding: 40px 0 20px;
            display: flex;
            justify-content: center;
            gap: 15px;
            animation: fadeIn 1.5s ease-in;
        }

        .filter-btn {
            padding: 10px 25px;
            border-radius: 50px;
            border: 2px solid var(--primary-teal);
            background: var(--white);
            color: var(--primary-teal);
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition);
        }

        .filter-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,121,107,0.2);
        }

        .filter-btn.active {
            background: var(--primary-teal);
            color: var(--white);
        }

        /* --- Card Grid --- */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px 20px 80px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
        }

        .card {
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            transition: var(--transition);
            animation: fadeInUp 0.8s ease-out both;
        }

        .card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .card-img { height: 220px; overflow: hidden; }
        .card-img img { 
            width: 100%; height: 100%; object-fit: cover; 
            transition: transform 0.6s ease;
        }

        .card:hover .card-img img {
            transform: scale(1.1);
        }

        .card-content { padding: 25px; flex-grow: 1; }

        .btn-detail {
            width: 100%;
            background: var(--bg-soft);
            color: var(--primary-teal);
            border: 1px solid var(--primary-teal);
            padding: 12px;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 15px;
        }

        .btn-detail:hover {
            background: var(--primary-teal);
            color: white;
            letter-spacing: 1px; /* Subtle effect for button only */
        }

        /* --- Modal Animation --- */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0; top: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.8);
            backdrop-filter: blur(5px); /* Modern blur effect */
            justify-content: center; align-items: center;
            animation: fadeIn 0.3s ease;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 25px;
            max-width: 650px;
            width: 90%;
            position: relative;
            animation: modalBounce 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<section class="hero">
    <h1>Taste of Meiktila</h1>
    <p>မိတ္ထီလာမြို့၏ ရိုးရာယဉ်ကျေးမှုနှင့် ဒေသထွက် အစားအစာများကို လေ့လာစမ်းသပ်နိုင်ပါသည်။</p>
    
    <div class="search-container">
        <i class="fas fa-search search-icon"></i>
        <input type="text" id="mainSearch" onkeyup="filterData()" placeholder="ရှာဖွေလိုသည့် အမည်ကို ရိုက်ထည့်ပါ...">
    </div>
</section>

<div class="filter-section">
    <button class="filter-btn active" onclick="filterCategory('All', this)">အားလုံး</button>
    <button class="filter-btn" onclick="filterCategory('Culture', this)">ရိုးရာ ပွဲတော်များ</button>
    <button class="filter-btn" onclick="filterCategory('Food', this)">စားသောက်ဖွယ်ရာ</button>
</div>

<div class="container">
    <div class="grid" id="dataGrid">
        <?php 
        $delay = 0; // To stagger the load animation
        if ($result && mysqli_num_rows($result) > 0):
            while($row = mysqli_fetch_assoc($result)): 
                $delay += 0.1;
        ?>
        <div class="card data-item" data-category="<?php echo $row['category']; ?>" style="animation-delay: <?php echo $delay; ?>s">
            <div class="card-img">
                <img src="Images/<?php echo $row['image_path']; ?>" alt="">
            </div>
            <div class="card-content">
                <h3 class="title-name"><?php echo $row['title']; ?></h3>
                <p><?php echo mb_substr(strip_tags($row['description']), 0, 100, "UTF-8"); ?>...</p>
                <button class="btn-detail" 
                    data-title="<?php echo htmlspecialchars($row['title'], ENT_QUOTES); ?>"
                    data-desc="<?php echo htmlspecialchars($row['description'], ENT_QUOTES); ?>"
                    data-img="Images/<?php echo $row['image_path']; ?>"
                    onclick="showDetail(this)">
                    အသေးစိတ်ကြည့်ရန်
                </button>
            </div>
        </div>
        <?php 
            endwhile;
        endif; 
        ?>
    </div>
</div>

<div id="detailModal" class="modal">
    <div class="modal-content">
        <span onclick="closeDetail()" style="position:absolute; right:25px; top:15px; font-size:35px; cursor:pointer; color: #999;">&times;</span>
        <img id="m-img" src="" style="width:100%; height: 300px; object-fit: cover; border-radius:15px; margin-bottom:15px;">
        <h2 id="m-title" style="color: var(--primary-teal);"></h2>
        <p id="m-desc" style="white-space: pre-wrap; line-height: 1.8; margin-top:15px; color: #555;"></p>
    </div>
</div>

<script>
// Search with filter
function filterData() {
    let input = document.getElementById('mainSearch').value.toLowerCase();
    let cards = document.getElementsByClassName('data-item');
    for (let card of cards) {
        let title = card.querySelector('.title-name').innerText.toLowerCase();
        card.style.display = title.includes(input) ? "flex" : "none";
    }
}

// Tab selection animation
function filterCategory(cat, btn) {
    let cards = document.getElementsByClassName('data-item');
    let buttons = document.getElementsByClassName('filter-btn');
    
    for (let b of buttons) b.classList.remove('active');
    btn.classList.add('active');

    for (let card of cards) {
        card.style.opacity = '0';
        card.style.transform = 'scale(0.9)';
        
        setTimeout(() => {
            if (cat === 'All' || card.dataset.category === cat) {
                card.style.display = "flex";
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'scale(1)';
                }, 50);
            } else {
                card.style.display = "none";
            }
        }, 300);
    }
}

function showDetail(btn) {
    document.getElementById('m-title').innerText = btn.dataset.title;
    document.getElementById('m-desc').innerText = btn.dataset.desc;
    document.getElementById('m-img').src = btn.dataset.img;
    document.getElementById('detailModal').style.display = 'flex';
    document.body.style.overflow = 'hidden'; // Prevent scroll
}

function closeDetail() {
    document.getElementById('detailModal').style.display = 'none';
    document.body.style.overflow = 'auto'; // Restore scroll
}

// Close modal on click outside
window.onclick = function(event) {
    if (event.target == document.getElementById('detailModal')) closeDetail();
}
</script>

</body>
</html>