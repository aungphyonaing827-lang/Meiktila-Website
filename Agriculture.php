<?php
session_start();
include 'db_connect.php'; // Database connection ချိတ်ဆက်ခြင်း
?>
<!DOCTYPE html>
<html lang="my">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Agri-Livestock Hub | Meiktila Guide</title>
    <link href="https://fonts.googleapis.com/css2?family=Pyidaungsu:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/style.css">
    <style>
        /* CSS Design ကို နဂိုပေးထားသည့်အတိုင်း ထိန်းသိမ်းထားပါသည် */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Pyidaungsu', sans-serif;
        }

        /* Hero Section */
        .hero-container {
            display: flex;
            height: 100vh;
            width: 100%;
            overflow: hidden;
            margin-top: -20px;
        }

        .panel {
            flex: 1 1 0;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: flex 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            background-size: cover;
            background-position: center;
            cursor: pointer;
            min-width: 0;
        }

        .agriculture {
            background-image: url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=1200');
        }

        .livestock {
            background-image: url('https://images.unsplash.com/photo-1500595046743-cd271d694d30?w=1200');
        }

        .panel:hover {
            flex: 4;
        }

        .overlay-mask {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.8));
        }

        .panel-content {
            position: relative;
            z-index: 10;
            color: white;
            text-align: center;
            width: 85%;
            opacity: 0;
            transform: translateY(30px);
            transition: 0.6s ease 0.2s;
        }

        .panel:hover .panel-content {
            opacity: 1;
            transform: translateY(0);
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
        }

        /* Grid Items */
        .sub-category-grid {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 30px;
            flex-wrap: wrap;
            max-width: 850px;
            margin: 0 auto 30px auto;
        }

        .grid-item {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            padding: 15px;
            border-radius: 12px;
            width: 150px;
            height: 190px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.4s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
        }

        .grid-item:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.2);
        }

        .grid-item img {
            width: 100%;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
        }

        /* Full Overlay Detail */
        .full-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            z-index: 9999;
            display: none;
            overflow-y: auto;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .full-overlay.active {
            opacity: 1;
        }

        .overlay-header {
            position: sticky;
            top: 0;
            background: white;
            z-index: 1100;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 40px;
            border-bottom: 2px solid #f0f0f0;
        }

        .overlay-body {
            padding: 40px 10%;
        }

        .detail-section {
            background: white;
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border-left: 8px solid #27ae60;
        }

        .detail-section h3 {
            font-size: 2.2rem;
            color: #333;
            margin-bottom: 20px;
        }

        .gallery {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .gallery img {
            width: 31%;
            height: 220px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .back-btn-overlay {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            background: #27ae60;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            border: none;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .hero-container {
                flex-direction: column;
            }

            .panel {
                height: 50vh;
            }

            .gallery img {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <?php include 'header.php'; ?>

    <main class="hero-container">
        <section class="panel agriculture">
            <div class="overlay-mask"></div>
            <div class="panel-content">
                <h1>စိုက်ပျိုးရေးဆိုင်ရာ နည်းလမ်းများ</h1>
                <div class="sub-category-grid">
                    <?php
                    $res_agri = mysqli_query($conn, "SELECT * FROM contents WHERE category = 'Agriculture' ORDER BY id DESC");
                    while ($row = mysqli_fetch_assoc($res_agri)): ?>
                        <div class="grid-item">
                            <img src="Images/<?php echo $row['image_path']; ?>" alt="Agri">
                            <span style="font-size: 11px; color: white; margin: 5px 0; text-align: center;"><?php echo $row['title']; ?></span>
                            <button class="back-btn-overlay" style="font-size: 10px; width: 100%; justify-content: center;"
                                onclick="openOverlay('agri-overlay', 'agri-<?php echo $row['id']; ?>')">ကြည့်မည်</button>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>

        <section class="panel livestock">
            <div class="overlay-mask"></div>
            <div class="panel-content">
                <h1>ခေတ်မီ မွေးမြူရေး ကဏ္ဍ</h1>
                <div class="sub-category-grid">
                    <?php
                    $res_live = mysqli_query($conn, "SELECT * FROM contents WHERE category = 'Livestock' ORDER BY id DESC");
                    while ($row = mysqli_fetch_assoc($res_live)): ?>
                        <div class="grid-item">
                            <img src="Images/<?php echo $row['image_path']; ?>" alt="Live">
                            <span style="font-size: 11px; color: white; margin: 5px 0; text-align: center;"><?php echo $row['title']; ?></span>
                            <button class="back-btn-overlay" style="font-size: 10px; width: 100%; justify-content: center;"
                                onclick="openOverlay('live-overlay', 'live-<?php echo $row['id']; ?>')">ကြည့်မည်</button>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
    </main>

    <div id="agri-overlay" class="full-overlay">
        <div class="overlay-header">
            <button class="back-btn-overlay" onclick="closeOverlay('agri-overlay')"><i class="fas fa-arrow-left"></i> ရှေ့သို့ ပြန်သွားမည်</button>
            <h2>စိုက်ပျိုးရေး အချက်အလက်များ</h2>
            <span style="font-size: 30px; cursor: pointer;" onclick="closeOverlay('agri-overlay')">&times;</span>
        </div>
        <div class="overlay-body">
            <?php
            mysqli_data_seek($res_agri, 0); // Pointer ကို ပြန်စတင်ခြင်း
            while ($row = mysqli_fetch_assoc($res_agri)): ?>
                <div class="detail-section" id="agri-<?php echo $row['id']; ?>">
                    <h3><?php echo $row['title']; ?></h3>
                    <div class="full-content" style="line-height: 1.8; color: #444;">
                        <p><strong><i class="fas fa-seedling"></i>စိုက်ပျိုးရသည့် အကြောင်းအရင်း:</strong><br> <?php echo nl2br($row['breeding_system']); ?></p><br>
                        <p><strong><i class="fas fa-check-circle"></i> စိုက်ပျိုးခြင်းနှင့် ပြုစုခြင်း:</strong><br> <?php echo nl2br($row['requirements']); ?></p><br>
                        <p><strong><i class="fas fa-chart-line"></i>ဈေးကွက်အကျိုးအမြတ်:</strong><br> <?php echo nl2br($row['market_benefit']); ?></p>
                    </div>
                    <div class="gallery">
                        <img src="Images/<?php echo $row['image_path']; ?>">
                        <?php if (!empty($row['img_extra1'])): ?><img src="Images/<?php echo $row['img_extra1']; ?>"><?php endif; ?>
                        <?php if (!empty($row['img_extra2'])): ?><img src="Images/<?php echo $row['img_extra2']; ?>"><?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <div id="live-overlay" class="full-overlay">
        <div class="overlay-header">
            <button class="back-btn-overlay" onclick="closeOverlay('live-overlay')"><i class="fas fa-arrow-left"></i> ရှေ့သို့ ပြန်သွားမည်</button>
            <h2>မွေးမြူရေး အချက်အလက်များ</h2>
            <span style="font-size: 30px; cursor: pointer;" onclick="closeOverlay('live-overlay')">&times;</span>
        </div>
        <div class="overlay-body">
            <?php
            mysqli_data_seek($res_live, 0);
            while ($row = mysqli_fetch_assoc($res_live)): ?>
                <div class="detail-section" id="live-<?php echo $row['id']; ?>">
                    <h3><?php echo $row['title']; ?></h3>
                    <div class="full-content" style="line-height: 1.8; color: #444;">
                        <p><strong><i class="fas fa-paw"></i> မွေးမြူရေးစနစ်များ:</strong><br> <?php echo nl2br($row['breeding_system']); ?></p><br>
                        <p><strong><i class="fas fa-star"></i> အောင်မြင်ရန် လိုအပ်ချက်များ:</strong><br> <?php echo nl2br($row['requirements']); ?></p><br>
                        <p><strong><i class="fas fa-first-aid"></i> ကျန်းမာရေးနှင့် ကာကွယ်စောင့်ရှောက်မှု:</strong><br> <?php echo nl2br($row['health_safety']); ?></p><br>
                        <p><strong><i class="fas fa-coins"></i> ဈေးကွက်နှင့် အကျိုးအမြတ်:</strong><br> <?php echo nl2br($row['market_benefit']); ?></p>
                    </div>
                    <div class="gallery">
                        <img src="Images/<?php echo $row['image_path']; ?>">
                        <?php if (!empty($row['img_extra1'])): ?><img src="Images/<?php echo $row['img_extra1']; ?>"><?php endif; ?>
                        <?php if (!empty($row['img_extra2'])): ?><img src="Images/<?php echo $row['img_extra2']; ?>"><?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        function openOverlay(id, targetId) {
            const overlay = document.getElementById(id);
            overlay.style.display = 'block';
            setTimeout(() => {
                overlay.classList.add('active');
                if (targetId) {
                    const element = document.getElementById(targetId);
                    if (element) element.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }, 100);
            document.body.style.overflow = 'hidden';
        }

        function closeOverlay(id) {
            const overlay = document.getElementById(id);
            overlay.classList.remove('active');
            setTimeout(() => {
                overlay.style.display = 'none';
            }, 300);
            document.body.style.overflow = 'auto';
        }
    </script>

</body>

</html>