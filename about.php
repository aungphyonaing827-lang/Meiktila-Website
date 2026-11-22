<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | CU Meiktila Tech Team</title>
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #1a2a6c;
            --secondary: #f2a900;
            --accent: #b21f1f;
            --bg: #f0f2f5;
            --white: #ffffff;
            --glass: rgba(255, 255, 255, 0.8);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Pyidaungsu', sans-serif; }
        
        body { 
            background-color: var(--bg); 
            color: #333; 
            overflow-x: hidden; 
        }

        /* --- Background Animation Container --- */
        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            background: linear-gradient(to bottom, #f8f9fa, #e9ecef);
        }

        /* --- Floating Translate Widget --- */
        #google_translate_element {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 99999;
            background: white;
            padding: 8px;
            border-radius: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        /* --- Hero Section with Blur Reveal --- */
        .hero {
            height: 65vh;
            background: linear-gradient(135deg, rgba(26,42,108,0.85), rgba(178,31,31,0.7)), url('Images/ucsbg.jpg');
            background-size: cover; 
            background-position: center;
            display: flex; align-items: center; justify-content: center;
            text-align: center; color: var(--white);
            clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%);
        }
        
        .hero-content h1 { 
            font-size: 3.5rem; 
            text-shadow: 2px 2px 10px rgba(0,0,0,0.3);
            animation: reveal 1.2s ease-out;
        }

        @keyframes reveal {
            from { filter: blur(10px); opacity: 0; transform: translateY(20px); }
            to { filter: blur(0); opacity: 1; transform: translateY(0); }
        }

        /* --- Layout --- */
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; position: relative; }
        .section-title { text-align: center; margin: 80px 0 50px; }
        .section-title h2 { font-size: 2.5rem; color: var(--primary); display: inline-block; position: relative; }
        .section-title h2::after {
            content: ''; width: 50%; height: 4px; background: var(--secondary);
            position: absolute; bottom: -10px; left: 25%; border-radius: 5px;
        }

        /* --- Modern Glass Cards --- */
        .about-box {
            background: var(--glass);
            backdrop-filter: blur(10px);
            padding: 50px; border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.05); text-align: center;
            line-height: 2.2; font-size: 1.1rem;
            border: 1px solid rgba(255,255,255,0.3);
        }

        .grid-3 { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; }
        
        .card {
            background: var(--glass);
            backdrop-filter: blur(5px);
            padding: 40px; border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.3);
            transform-style: preserve-3d;
            perspective: 1000px;
        }

        .card i { transition: transform 0.5s ease; }
        .card:hover i { transform: translateZ(50px) scale(1.2); color: var(--secondary) !important; }

        /* --- Team Grid --- */
        .team-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 25px; }
        .member-card {
            background: var(--white); padding: 25px; border-radius: 15px;
            text-align: center; transition: 0.3s;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .member-card:hover { background: var(--primary); color: white; }
        .member-card img {
            width: 110px; height: 110px; border-radius: 50%;
            object-fit: cover; margin-bottom: 15px;
            border: 3px solid var(--secondary); transition: 0.6s;
        }
        .member-card:hover img { transform: scale(2.2) rotate(10deg); }

/* --- Footer (Fixed) --- */
        footer { background: var(--primary); color: white; padding: 60px 0 20px; margin-top: 80px; }
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }
        .footer-link { color: #aaa; text-decoration: none; transition: 0.3s; display: block; margin-bottom: 10px; }
        .footer-link:hover { color: var(--secondary); padding-left: 8px; }
        .footer-bottom {
            text-align: center;
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 20px;
            font-size: 0.9rem;
        }

        

        @media (max-width: 768px) { .hero-content h1 { font-size: 2.2rem; } }
    </style>
</head>
<body>

    <div id="particles-js"></div>

    <div id="google_translate_element"></div>

    <?php
    $team_members = [
        ["name" => "Mg Min Htet Naing", "img" => "member1.jpg"],
        ["name" => "Mg Wai Phyo Thar", "img" => "member2.jpg"],
        ["name" => "Mg Aung Phyo Naing", "img" => "apn1.jpg"],
        ["name" => "Mg Shwe Phyo(1)", "img" => "sp1.jpg"],
        ["name" => "Mg Shwe Phyo(2)", "img" => "sp2.jpg"],
        ["name" => "Mg Hein Zarni Moe", "img" => ""],
        ["name" => "Mg Zin Min Oo", "img" => "zmo.jpg"],
        ["name" => "Ma Hnin Pa Pa Hlaing", "img" => "hpph.jpg"],
        ["name" => "Ma Zin Zin Thaw", "img" => "zzt.jpg"],
        ["name" => "Ma Mani Sandar", "img" => "mnsd.jpg"],
        ["name" => "Ma Thet Mon Win", "img" => "photo_2026-02-19_15-59-48.jpg"],
        ["name" => "Ma Aye Aye Mar", "img" => "aam.jpg"],
        ["name" => "Ma Khaing Zin Htet", "img" => "kzg.jpg"],
        ["name" => "Ma Myat Moe San", "img" => "mms.jpg"],
        ["name" => "Mg Zin Lin Oo", "img" => "member5.jpg"]
    ];
    ?>

    <section class="hero">
        <div class="hero-content">
            <h1>Computer University (Meiktila)</h1>
            <p style="letter-spacing: 3px;">INNOVATION • TECHNOLOGY • EDUCATION</p>
        </div>
    </section>

    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Who We Are (ကျွန်ုပ်တို့အကြောင်း)</h2>
        </div>
        <div class="about-box" data-aos="fade-up">
            <p>ကျွန်ုပ်တို့သည် နည်းပညာကို စိတ်အားထက်သန်သော Computer University (Meiktila) မှ ကျောင်းသားအဖွဲ့တစ်ဖွဲ့ ဖြစ်ပါသည်။ ကျွန်ုပ်တို့၏ ရည်မှန်းချက်မှာ ခေတ်မီနည်းပညာများကို အသုံးပြု၍ လူမှုပတ်ဝန်းကျင်အတွက် အမှန်တကယ် အကျိုးရှိစေမည့် software နှင့် digital ဖြေရှင်းချက်များကို ဖန်တီးတည်ဆောက်ရန် ဖြစ်ပါသည်။</p>
        </div>

        <div class="section-title" data-aos="fade-right">
            <h2>Our Services (ဝန်ဆောင်မှုများ)</h2>
        </div>
        <div class="grid-3">
            <div class="card" data-tilt>
                <i class="fas fa-laptop-code fa-3x" style="color:var(--primary); margin-bottom:15px;"></i>
                <h3>Web Design</h3>
                <p>ဆွဲဆောင်မှုရှိပြီး ဖုန်း၊ ကွန်ပျူတာအားလုံးနှင့် ကိုက်ညီသော website များ ဖန်တီးပေးခြင်း။</p>
            </div>
            <div class="card" data-tilt>
                <i class="fas fa-layer-group fa-3x" style="color:var(--primary); margin-bottom:15px;"></i>
                <h3>Development</h3>
                <p>ခိုင်မာမြန်ဆန်သော ကုဒ်စနစ်များဖြင့် လုပ်ငန်းသုံး software များ ရေးသားခြင်း။</p>
            </div>
            <div class="card" data-tilt>
                <i class="fas fa-mobile-alt fa-3x" style="color:var(--primary); margin-bottom:15px;"></i>
                <h3>UI/UX Optimization</h3>
                <p>အသုံးပြုသူများ အဆင်ပြေချောမွေ့စေမည့် interface ဒီဇိုင်းများကို ဖော်ဆောင်ခြင်း။</p>
            </div>
        </div>

        <div class="section-title" data-aos="fade-up">
            <h2>Meet Our Team</h2>
        </div>
        <div class="team-grid">
            <?php foreach($team_members as $index => $member): ?>
            <div class="member-card" data-aos="zoom-in" data-aos-delay="<?php echo ($index % 5) * 100; ?>">
                <img src="images/<?php echo $member['img']; ?>" alt="<?php echo $member['name']; ?>">
                <h4><?php echo $member['name']; ?></h4>
                <p style="font-size: 0.8rem; color: #777;">Student</p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer>
        <footer>
        <div class="container">
            <div class="footer-content">
                <div>
                    <h3>CU Meiktila Team</h3>
                    <p style="margin-top: 15px; color: #ccc;">နည်းပညာနှင့် ဆန်းသစ်တီထွင်မှုများဖြင့် အနာဂတ်ကို အတူတကွ တည်ဆောက်ကြပါစို့။</p>
                </div>
                <div>
                    <h4>Quick Links</h4>
                    <ul style="list-style: none; margin-top: 15px; line-height: 2;">
                        <li><a href="index.php" class="footer-link">Home</a></li>
                        <li><a href="history.php" class="footer-link">History</a></li>
                        <li><a href="contact.php" class="footer-link">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Connect</h4>
                    <ul style="list-style: none; margin-top: 15px; line-height: 2;">
                        <li><a href="http://www.instagram.com/jr.shwephyo" class="footer-link" target="_blank">Instagram</a></li>
                        <li><a href="https://t.me/shwephyojr10124" class="footer-link" target="_blank">Telegram</a></li>
                        <li><a href="https://www.tiktok.com/@shwephyo522" class="footer-link" target="_blank">Tiktok</a></li>
                    </ul>
                </div>
            </div>
            
        </div>
        <div class="container">
            <div class="footer-bottom">
                &copy; <?php echo date("Y"); ?> Tech Team | Computer University (Meiktila). All Rights Reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.7.0/vanilla-tilt.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Initialize AOS
        AOS.init({ duration: 1000, once: true });

        // Initialize Particles
        particlesJS("particles-js", {
            "particles": {
                "number": { "value": 60 },
                "color": { "value": "#1a2a6c" },
                "shape": { "type": "circle" },
                "opacity": { "value": 0.1 },
                "size": { "value": 3 },
                "line_linked": { "enable": true, "distance": 150, "color": "#1a2a6c", "opacity": 0.1, "width": 1 },
                "move": { "enable": true, "speed": 1.5 }
            },
            "interactivity": {
                "events": { "onhover": { "enable": true, "mode": "grab" } }
            }
        });

       
        
    </script>
    <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>
</html>