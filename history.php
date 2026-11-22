<?php
session_start();
include 'db_connect.php';

/**
 * ၁။ Database မှ History Category ဒေတာများကို ဆွဲထုတ်ခြင်း
 */
$query = "SELECT * FROM contents WHERE category = 'History' ORDER BY sub_category ASC, id ASC";
$result = mysqli_query($conn, $query);

$history_groups = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $group_name = !empty($row['sub_category']) ? $row['sub_category'] : 'အထွေထွေ';
        $history_groups[$group_name][] = $row;
    }
}

/**
 * Header Static Data
 */
$header_data = [
    "img" => "Images/photo_2025-12-29_20-00-34.jpg",
    "title_mm" => "မိတ္ထီလာမြို့၏ သမိုင်းဝင်အမွေအနှစ်များ",
    "hist_mm" => "မိတ္ထီလာမြို့သည် ရှေးအခါက သျှိသျှားမြို့ဟု တွင်ခဲ့သည်။ ကန်တော်ကို အစွဲပြု၍တွင်သော 
    အမည်ဖြစ်ရကား ကန်တော်အမည်ပြောင်းသည်နှင့်အမျှ မြို့၏ အမည်လည်း ပြောင်းလဲခဲ့ပေသည်။ ယခုတွင်လျက်ရှိသော 
    မိတ္ထီလာဟူသော အမည်ကား ပုဂံအနော်ရထာမင်း၏ လက်ထက်တော်မှစ၍မထိလာဟူသော အမည်မှကာလရွေ့လျောသည့်အလျောက်
     ပြောင်းလဲလာသောအမည်ဖြစ်သည်ဟု ဆိုလေသည်။မိတ္ထီလာကန်တော်သည် မြို့ ကျက်သရေဆောင်ဖြစ်သကဲ့သို၊ မြန်မာ့သမိုင်းနှင့်လည်း 
     ဆက်စပ်နေသည်။အနော်ရထာ မင်းကြီးမှ စတင်ဆည်ဖို့ခဲ့ပြီး အလောင်းစည်သူမင်းပြုပြင်တည်ဆောက်ခဲ့သည်။ကန်တော်အတွင်းရှိ အန္တကူ
      ရေလည်ဘုရားမှာလည်း ထင်ရှားသည်။ ကန်တော်ကမ်းပါးရှိ ဖောင်တော်ဦးစေတီတော်သည်လည်း ထင်ရှားသော စေတီတစ်ဆူဖြစ်သည်။ 
      နှစ်စဉ် တော်သလင်းလတွင် စည်ကားသိုက်မြိုက်စွာ 
    ဖောင်တော်ဦးစေတီတော်၏ ဘုရားပွဲတော်ကျင်းပလေ့ရှိသည်။ လှေပြိုင်ပွဲများလည်း ထည့်သွင်းကျင်းပသည်။"
];
?>

<!DOCTYPE html>
<html lang="my">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History | Meiktila Guide</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Professional Color Palette */
        :root {
            --bg-sidebar:white;
            /* Deep Charcoal */
            --bg-body:white;
            /* Dark Slate */
            --bg-card:white;
            /* Lighter Grey-Blue */
            --primary-gold: #d4af37;
            /* Metallic Gold */
            --text-main: #e0e0e0;
            --text-muted: #a0a0a0;
            --accent-glow: rgba(212, 175, 55, 0.3);
        }

        body {
            background-color: white;
            color: #c0c018;
            font-family: 'Pyidaungsu', sans-serif;
            margin: 0;
            display: flex;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 280px;
            height: 100vh;
            background: var(--bg-sidebar);
            position: fixed;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            z-index: 1000;
        }

        .brand {
            padding: 30px;
            font-size: 24px;
            font-weight: bold;
            color: var(--primary-gold);
            text-align: center;
            letter-spacing: 3px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Back Button */
        .btn-back {
            margin: 20px;
            padding: 12px;
            background: transparent;
            color: var(--primary-gold);
            border: 1px solid var(--primary-gold);
            border-radius: 8px;
            text-decoration: none;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 14px;
            transition: 0.3s;
        }

        .btn-back:hover {
            background: var(--primary-gold);
            color: white;
        }

        nav {
            padding: 10px;
            flex-grow: 1;
        }

        .nav-item {
            padding: 15px 20px;
            margin: 5px 0;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 15px;
            color: #d4af37;
            transition: 0.3s;
        }

        .nav-item:hover,
        .nav-item.active {
            background: rgba(212, 175, 55, 0.1);
            color: var(--primary-gold);
        }

        /* Main Content area */
        .wrapper {
            margin-left: 280px;
            width: calc(100% - 280px);
            min-height: 100vh;
        }

        header {
            display: flex;
            padding: 50px;
            background: linear-gradient(to right, white, white);
            align-items: center;
            gap: 40px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .header-img {
            width: 250px;
            height: 250px;
            border-radius: 20px;
            object-fit: cover;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            border: 2px solid var(--primary-gold);
        }

        .header-info h1 {
            font-size: 32px;
            color: var(--primary-gold);
            margin-bottom: 15px;
        }

        .header-info p {
            max-width: 600px;
            line-height: 1.8;
            color: #b97f1b;
        }

        /* Content Grid */
        .group-header {
            padding: 40px 50px 10px;
            font-size: 22px;
            color: var(--primary-gold);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .history-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            padding: 30px 50px;
        }

        .mini-card {
            background: var(--bg-card);
            border-radius: 15px;
            overflow: hidden;
            transition: 0.4s;
            border: 1px solid rgba(255, 255, 255, 0.05);
            cursor: pointer;
        }

        .mini-card:hover {
            transform: translateY(-10px);
            border-color: var(--primary-gold);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .mini-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card-label {
            padding: 20px;
            text-align: center;
            font-weight: bold;
            background: #242830;
        }

        /* Detail Area */
        .modern-detail-card {
            background: #121418;
            border: 1px solid var(--primary-gold);
            border-radius: 20px;
            padding: 30px;
            margin: 20px 50px;
            display: none;
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .detail-flex {
            display: flex;
            gap: 30px;
        }

        .detail-img {
            width: 40%;
            border-radius: 15px;
        }

        .detail-text {
            width: 60%;
        }

        .btn-close {
            background: var(--primary-gold);
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            font-weight: bold;
        }

        @media (max-width: 1000px) {
            .sidebar {
                width: 70px;
            }

            .sidebar span,
            .brand,
            .btn-back span {
                display: none;
            }

            .wrapper {
                margin-left: 70px;
                width: calc(100% - 70px);
            }

            header {
                flex-direction: column;
                text-align: center;
            }

            .detail-flex {
                flex-direction: column;
            }

            .detail-img,
            .detail-text {
                width: 100%;
            }
        }
    </style>
</head>

<body>


    <aside class="sidebar">
        <div class="brand">MEIKTILA</div>

        <a href="index.php" class="btn-back">
            <i class="fas fa-home"></i> <span>Home သို့ပြန်သွားရန်</span>
        </a>

        <nav>
            <div class="nav-item active" onclick="showAll(this)">
                <i class="fas fa-th-large"></i> <span>အားလုံးကြည့်မည်</span>
            </div>

            <?php
            $nav_idx = 0;
            foreach (array_keys($history_groups) as $group_title):
            ?>
                <div class="nav-item" onclick="showCategory('group-<?= $nav_idx ?>', this)">
                    <i class="fas fa-landmark"></i> <span><?= htmlspecialchars($group_title) ?></span>
                </div>
            <?php $nav_idx++;
            endforeach; ?>
        </nav>
    </aside>

    <div class="wrapper">
        <header>
            <img src="<?= $header_data['img'] ?>" class="header-img">
            <div class="header-info">
                <h1><?= $header_data['title_mm'] ?></h1>
                <p><?= $header_data['hist_mm'] ?></p>
            </div>
        </header>

        <main>
            <?php
            $g_idx = 0;
            foreach ($history_groups as $group_name => $items):
            ?>
                <section id="group-<?= $g_idx ?>" class="content-section">
                    <div class="group-header">
                        <i class="fas fa-history"></i> <?= htmlspecialchars($group_name) ?>
                    </div>

                    <div class="history-grid">
                        <?php foreach ($items as $item): ?>
                            <div class="mini-card" onclick="showDetail('<?= $item['id'] ?>')">
                                <img src="Images/<?= htmlspecialchars($item['image_path']) ?>" onerror="this.src='Images/default.jpg'">
                                <div class="card-label">
                                    <?= htmlspecialchars($item['title']) ?>
                                </div>
                            </div>

                            <div id="detail-<?= $item['id'] ?>" class="modern-detail-card" style="grid-column: 1 / -1;">
                                <div class="detail-flex">
                                    <img src="Images/<?= htmlspecialchars($item['image_path']) ?>" class="detail-img">
                                    <div class="detail-text">
                                        <h2 style="color:var(--primary-gold);"><?= htmlspecialchars($item['title']) ?></h2>
                                        <p style="line-height:1.8; color:var(--text-muted);">
                                            <?= nl2br(htmlspecialchars($item['description'])) ?>
                                        </p>
                                        <button class="btn-close" onclick="closeDetail('<?= $item['id'] ?>')">Close</button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php $g_idx++;
            endforeach; ?>
        </main>
    </div>

    <script>
        // Detail Box ဖွင့်ခြင်း
        function showDetail(id) {
            document.querySelectorAll('.modern-detail-card').forEach(box => box.style.display = 'none');
            const target = document.getElementById('detail-' + id);
            target.style.display = 'block';
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }

        // Detail Box ပိတ်ခြင်း
        function closeDetail(id) {
            document.getElementById('detail-' + id).style.display = 'none';
        }

        // Sidebar Navigation
        function showAll(el) {
            document.querySelectorAll('.content-section').forEach(s => s.style.display = "block");
            setActive(el);
        }

        function showCategory(id, el) {
            document.querySelectorAll('.content-section').forEach(s => s.style.display = "none");
            document.getElementById(id).style.display = "block";
            setActive(el);
        }

        function setActive(el) {
            document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
            el.classList.add('active');
        }
    </script>
</body>

</html>