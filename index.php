<?php 
session_start();
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Experience Meiktila | The Heart of Myanmar</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&family=Noto+Sans+Myanmar:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="stylesheet" href="CSS/style.css">

    <style>
        :root {
            --primary: #006a4e;
            --accent: #d4af37;
            --dark: #121212;
            --glass: rgba(255, 255, 255, 0.1);
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Noto Sans Myanmar', sans-serif;
            background-color: #fdfdfd;
            overflow-x: hidden;
        }

        /* --- Hero Section with Parallax Effect --- */
        .hero {
            position: relative;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7)), url('Images/bg.jpg');
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
            clip-path: ellipse(150% 100% at 50% 0%); /* Modern curved bottom */
        }

        .hero-content h1 {
            font-size: clamp(3rem, 8vw, 5.5rem);
            font-weight: 800;
            letter-spacing: -2px;
            margin-bottom: 10px;
            background: linear-gradient(to right, #fff, var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-content p {
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto 40px;
            opacity: 0.9;
        }

        /* --- Floating Action Buttons --- */
        .cta-group {
            display: flex;
            gap: 20px;
            justify-content: center;
        }

        .btn-main {
            padding: 16px 35px;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-primary { background: var(--accent); color: #000; }
        .btn-outline { border: 2px solid #fff; color: #fff; }

        .btn-main:hover { transform: translateY(-5px) scale(1.05); box-shadow: 0 15px 30px rgba(212, 175, 55, 0.3); }

        /* --- Stats/Fast Facts Section --- */
        .stats-bar {
            display: flex;
            justify-content: space-around;
            max-width: 1000px;
            margin: -60px auto 0;
            background: white;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 10;
        }

        .stat-item h3 { color: var(--primary); font-size: 2rem; margin: 0; }
        .stat-item span { color: #666; font-size: 0.9rem; font-weight: 600; text-transform: uppercase; }

        /* --- Modern Info Section --- */
        .about-modern {
            padding: 120px 10%;
            display: flex;
            gap: 80px;
            align-items: center;
        }

        .img-stack {
            position: relative;
            flex: 1;
        }

        .img-stack img {
            width: 100%;
            border-radius: 30px;
            z-index: 2;
            position: relative;
            filter: grayscale(20%);
            transition: 0.5s;
        }

       

        /* --- Explorer Cards --- */
        .section-header { text-align: center; margin-bottom: 60px; }
        .section-header h2 { font-size: 2.8rem; color: var(--primary); }

        .explorer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            padding: 0 10%;
            margin-bottom: 100px;
        }

        .explorer-card {
            height: 400px;
            border-radius: 24px;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            transition: 0.5s;
        }

        .explorer-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.6s;
        }

        .card-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 40px;
            background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);
            color: white;
            transform: translateY(20px);
            transition: 0.4s;
        }

        .explorer-card:hover img { transform: scale(1.1); }
        .explorer-card:hover .card-overlay { transform: translateY(0); }

        /* Scroll Progress Bar */
        #progress {
            position: fixed;
            top: 0; left: 0;
            height: 4px; background: var(--accent);
            z-index: 1000; transition: width 0.1s;
        }

        @media (max-width: 900px) {
            .about-modern { flex-direction: column; text-align: center; }
            .hero-content h1 { font-size: 3rem; }
            .cta-group { flex-direction: column; }
        }
        /* Card Overlay ကို Hover လုပ်တဲ့အခါ အရောင်ပြောင်းလဲမှု ပိုသိသာစေရန် */
.explorer-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0, 106, 78, 0.2); /* Primary Green Tint */
    z-index: 1;
    opacity: 0;
    transition: 0.5s;
}

.explorer-card:hover::before {
    opacity: 1;
}

.card-overlay h3 {
    font-family: 'Noto Sans Myanmar', sans-serif;
    font-size: 1.5rem;
    margin: 10px 0;
}

.card-overlay p {
    font-size: 0.9rem;
    opacity: 0.8;
}
    </style>
</head>
<body>

<div id="progress"></div>

<?php include 'header.php'; ?>

<section class="hero">
    <div class="hero-content" data-aos="fade-up">
        <span style="text-transform: uppercase; letter-spacing: 5px; font-weight: bold; color: var(--accent);">Welcome to Meiktila</span>
        <h1>​ရေကန်သာ၊ သမိုင်းဖြာ<br>လှမ်းခဲ့ပါ မိတ္ထီလာ</h1>
        <p>​Meiktila: Where Scenic Lakes Meet Timeless History​</p>
        <div class="cta-group">
            <a href="#about" class="btn-main btn-primary">ပိုမိုလေ့လာရန် <i class="fas fa-arrow-right"></i></a>
            <a href="landmarks.php" class="btn-main btn-outline">အထင်ကရနေရာများသို့</a>
        </div>
    </div>
</section>

<div class="stats-bar" data-aos="zoom-in">
    <div class="stat-item">
        <h3>10+</h3>
        <span>Universities</span>
    </div>
    <div class="stat-item">
        <h3>1000+</h3>
        <span>Years of History</span>
    </div>
    <div class="stat-item">
        <h3>2</h3>
        <span>Historic Lakes</span>
    </div>
</div>

<section class="about-modern" id="about">
    <div class="img-stack" data-aos="fade-right">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d59647.7478685125!2d95.81977755!3d20.8716335!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30cb690226c6d04d%3A0x7c73361e695d7f1d!2sMeiktila!5e0!3m2!1sen!2smm!4v1710000000000!5m2!1sen!2smm" 
            width="100%" 
            height="100%" 
            style="border:0; border-radius: 40px; min-height: 400px;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
   <div class="about-text" data-aos="fade-left" style="flex: 1;">

        <h4 style="font-size: 2.5rem; color: var(--primary); margin-bottom: 10px;">ပညာဗဟုသုတနှင့်ရေမြေ<br>အလှတရားတို့ ကိန်းဝပ်ရာ</h4>

        <p style="font-size: 1.1rem; color: #555; line-height: 2;">မိတ္ထီလာမြို့ဟာ သွားရောက်လည်ပတ်စရာ နေရာတစ်ခုသက်သက်တင် မဟုတ်ဘဲ သမိုင်းကြောင်းနဲ့ အနာဂတ်တို့ ဆုံစည်းရာ <b> မဟာဗျူဟာကျတဲ့ လမ်းဆုံလမ်းခွမြို့ တစ်မြို့လည်း ဖြစ်ပါတယ်။ </b>, အထက်မြန်မာပြည်ရဲ့ "ပညာရေးဗဟိုချက်မ" လို့ လူသိများတဲ့အလျောက် လေကြောင်းပညာ၊ နည်းပညာနဲ့ စီးပွားရေးကဏ္ဍတွေမှာ နိုင်ငံတော်အတွက် ထူးချွန်ထက်မြက်တဲ့ မျိုးဆက်သစ်တွေကို မွေးထုတ်ပေးနေတဲ့ မြို့ဖြစ်ပါတယ်။

</p>

       

    </div>
</section>

<section class="section-header" data-aos="fade-up">
    <h2>မိမိစိတ်ဝင်စားရာ ကဏ္ဍအလိုက် လေ့လာဖတ်ရှုပါ</h2>
    <p>မိတ္ထီလာမှာ ဘာတွေရှိမလဲ? သင့်ခရီးစဉ်ကို ကိုယ်တိုင်ရွေးချယ်ပြီး အသစ်သစ်သော အတွေ့အကြုံတွေကို စတင်လိုက်ပါ။</p>
</section>

<div class="explorer-grid">
    <div class="explorer-card" data-aos="fade-up" data-aos-delay="100" onclick="location.href='education.php'">
        <img src="Images/photo_2026-02-19_10-09-12.jpg" alt="Education">
        <div class="card-overlay">
            <i class="fas fa-graduation-cap fa-2x" style="color:var(--accent)"></i>
            <h3>The Knowledge Hub</h3>
            <p>မြန်မာနိုင်ငံ၏ ထိပ်တန်းနည်းပညာနှင့် လေကြောင်းပညာရပ်ဆိုင်ရာ တက္ကသိုလ်ကြီးများဆီသို့ လှည့်လည်ကြည့်ရှု လေ့လာလိုက်ပါ။</p>
        </div>
    </div>

    <div class="explorer-card" data-aos="fade-up" data-aos-delay="200" onclick="location.href='history.php'">
        <img src="https://images.unsplash.com/photo-1514282401047-d79a71a590e8?q=80&w=1000" alt="Landmarks">
        <div class="card-overlay">
            <i class="fas fa-temple fa-2x" style="color:var(--accent)"></i>
            <h3>Ancient Marvels</h3>
            <p>ကြည်နူးဖွယ်ရာ ကန်ရေပြင်အလှနှင့်အတူ သမိုင်းဝင် စေတီ​တော်များနှင့် သိမ်ကိုးသိမ်သို့ လာရောက်လေ့လာ ဖူးမြော်လိုက်ပါ။</p>
        </div>
    </div>

    <div class="explorer-card" data-aos="fade-up" data-aos-delay="300" onclick="location.href='culture_food.php'">
        <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=1000" alt="Food">
        <div class="card-overlay">
            <i class="fas fa-bowl-food fa-2x" style="color:var(--accent)"></i>
            <h3>Taste & Tradition</h3>
            <p>အရသာစစ်စစ် အညာဒေသရိုးရာ မုန့်ပဲသရေစာများကို မြည်းစမ်းရင်း စည်ကားလှတဲ့ အညာပွဲလမ်းသဘင်တွေမှာ ပျော်ပျော်ပါးပါး ဆင်နွှဲလိုက်ပါ။</p>
        </div>
    </div>
</div>
<div class="explorer-grid">
    <div class="explorer-card" data-aos="fade-up" data-aos-delay="400" onclick="location.href='transportation.php'">
        <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?q=80&w=1000" alt="Transportation">
        <div class="card-overlay">
            <i class="fas fa-bus fa-2x" style="color:var(--accent)"></i>
            <h3>City Logistics</h3>
            <p>သွားလာရေး လမ်းညွှန်နှင့် ကားဂိတ်များ အချက်အလက်။</p>
        </div>
    </div>

    <div class="explorer-card" data-aos="fade-up" data-aos-delay="500" onclick="location.href='Agriculture.php'">
        <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=1000" alt="Agriculture">
        <div class="card-overlay">
            <i class="fas fa-seedling fa-2x" style="color:var(--accent)"></i>
            <h3>Agri & Livestock</h3>
            <p>ဒေသထွက်ကုန်များနှင့် စိုက်ပျိုးမွေးမြူရေး ကဏ္ဍ။</p>
        </div>
    </div>

    <div class="explorer-card" data-aos="fade-up" data-aos-delay="600" onclick="location.href='contact.php'">
        <img src="https://images.unsplash.com/photo-1423666639041-f56000c27a9a?q=80&w=1000" alt="Contact Us">
        <div class="card-overlay">
            <i class="fas fa-envelope-open-text fa-2x" style="color:var(--accent)"></i>
            <h3>Get In Touch</h3>
            <p>ကျွန်ုပ်တို့ထံ အကြံပြုစာများ ပေးပို့နိုင်ပါသည်။</p>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    // Initialize Scroll Animations
    AOS.init({ duration: 1000, once: true });

    // Scroll Progress Bar Logic
    window.onscroll = function() {
        let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        let scrolled = (winScroll / height) * 100;
        document.getElementById("progress").style.width = scrolled + "%";
    };
</script>

</body>
</html>