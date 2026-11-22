<?php include 'data.php'; ?>
<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <title>Meiktila Heritage - Premium Edition</title>
    <link rel="stylesheet" href="CSS/history.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <aside class="sidebar">
        <div class="brand">MEIKTILA</div>
        <nav>
            <div class="nav-item active lang" onclick="showMain(this)" data-mm="ပင်မစာမျက်နှာ" data-en="HOME">
                <i class="fas fa-home"></i> <span>ပင်မစာမျက်နှာ</span>
            </div>
            <?php foreach($sections as $id => $sec): ?>
            <div class="nav-item lang" onclick="showCategory('<?= $id ?>', this)" data-mm="<?= $sec['title_mm'] ?>" data-en="<?= $sec['title_en'] ?>">
                <span><?= $sec['title_mm'] ?></span>
            </div>
            <?php endforeach; ?>
        </nav>
        <div style="margin-top: auto; display: grid; gap: 15px; padding-bottom: 20px;">
            <button class="luxury-btn lang" onclick="toggleLang()" data-mm="MM / EN" data-en="EN / MM">MM / EN</button>
            <button class="luxury-btn" onclick="toggleTheme()"><i class="fas fa-adjust"></i></button>
        </div>
    </aside>

    <div class="wrapper">
        <header class="header-split">
            <div class="header-left"><img src="<?= $header_data['img'] ?>"></div>
            <div class="header-right">
                <div>
                    <h1 class="lang" data-mm="<?= $header_data['title_mm'] ?>" data-en="<?= $header_data['title_en'] ?>" style="font-size: 3.2rem;"><?= $header_data['title_mm'] ?></h1>
                    <p class="lang" data-mm="<?= $header_data['hist_mm'] ?>" data-en="<?= $header_data['hist_en'] ?>" style="color:var(--text-muted); line-height:1.8;"><?= $header_data['hist_mm'] ?></p>
                </div>
            </div>
        </header>

        <main class="content">
            <?php foreach($sections as $id => $sec): ?>
            <section id="<?= $id ?>" class="content-section">
                
                <div class="feature-card">
                    <div style="flex: 1;"><img src="<?= $sec['main_img'] ?>" class="f-img"></div>
                    <div style="flex: 1.2;">
                        <h2 class="lang" data-mm="<?= $sec['title_mm'] ?>" data-en="<?= $sec['title_en'] ?>" style="color:var(--gold-primary); font-size: 2.2rem;"><?= $sec['title_mm'] ?></h2>
                        <p class="lang" data-mm="<?= $sec['main_hist_mm'] ?>" data-en="<?= $sec['main_hist_en'] ?>" style="color:var(--text-muted); line-height: 1.8;"><?= $sec['main_hist_mm'] ?></p>
                        <button class="luxury-btn lang" onclick="toggleExplore('<?= $id ?>')" data-mm="ပိုမိုကြည့်ရှုရန်↓" data-en="See More ↓">ပိုမိုကြည့်ရှုရန် ↓</button>
                    </div>
                </div>

                <div id="grid-<?= $id ?>" class="explore-container" style="display:none; padding: 0 40px 60px;">
                    <h3 class="lang" data-mm="ဓာတ်ပုံမှတ်တမ်းများ" data-en="Photo Gallery" style="color:var(--gold-primary); margin-bottom: 25px; text-align: center;">ဓာတ်ပုံမှတ်တမ်းများ</h3>
                    
                    <div class="another-photos-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px;">
                        <?php foreach($sec['others'] as $idx => $other): ?>
                       <div class="mini-card" onclick="showShortInfo('<?= $id ?>', '<?= $idx ?>')" ... >
    <img src="<?= $other['img'] ?>" style="width: 100%; height: 100%; object-fit: cover;">
    <div class="lang" 
         data-mm="<?= $other['t_mm'] ?>" 
         data-en="<?= $other['t_en'] ?>" 
         style="position: absolute; bottom: 0; width: 100%; background: rgba(0,0,0,0.7); padding: 5px; text-align: center; color: var(--gold-primary); font-size: 0.8rem;">
        <?= $other['t_mm'] ?>
    </div>
</div>
                        <?php endforeach; ?>
                    </div>

                    <div id="info-box-<?= $id ?>" class="result-box modern-detail-card" style="display:none;">
    <div class="detail-container">
        
        <div class="detail-left">
            <div class="image-frame-v2">
                <img id="detail-img-<?= $id ?>" src="" alt="Heritage Image">
            </div>
        </div>

        <div class="detail-right">
            <div class="detail-header">
                <h3 id="info-title-<?= $id ?>" class="gold-neon-text"></h3>
                <div class="accent-line"></div>
            </div>

            <div class="detail-scroll-area">
                <div id="short-history-<?= $id ?>" class="history-content short-text"></div>
                
                <div id="more-than-btn-<?= $id ?>" class="expand-btn-wrapper">
                    <span class="lang read-more-link" data-mm="ဆက်လက်ဖတ်ရှုရန် ↓" data-en="READ MORE ↓" onclick="showFullHistory('<?= $id ?>')">
                        ဆက်လက်ဖတ်ရှုရန် ↓
                    </span>
                </div>

                <div id="full-history-<?= $id ?>" class="history-content full-text" style="display:none;"></div>
            </div>

            <div class="detail-actions">
                <button class="luxury-btn lang close-btn" 
                        data-mm="ပိတ်မည်" 
                        data-en="CLOSE" 
                        onclick="document.getElementById('info-box-<?= $id ?>').style.display='none'">
                    ပိတ်မည်
                </button>
            </div>
        </div>

    </div>
</div>
            </section>
            <?php endforeach; ?>
        </main>
    </div>

    <script>
        // PHP Data ကို JS ထဲသို့ ထည့်သွင်းခြင်း
        const heritageData = <?= json_encode($sections) ?>;
        let currentLang = 'mm';

        function toggleLang() {
            currentLang = (currentLang === 'mm') ? 'en' : 'mm';
            document.querySelectorAll('.lang').forEach(el => {
                const text = el.getAttribute('data-' + currentLang);
                if(text) el.innerText = text;
            });
        }

        function toggleTheme() { document.body.classList.toggle('light-mode'); }

        // Explore Section ကို ဖွင့်/ပိတ်ခြင်း
        function toggleExplore(id) {
            let container = document.getElementById('grid-' + id);
            container.style.display = (container.style.display === "none") ? "block" : "none";
            if(container.style.display === "block") container.scrollIntoView({ behavior: 'smooth' });
        }

        // ပုံနှိပ်လိုက်လျှင် Short History အရင်ပြခြင်း
        function showShortInfo(sid, idx) {
    const item = heritageData[sid]['others'][idx];
    const box = document.getElementById('info-box-' + sid);
    const title = document.getElementById('info-title-' + sid);
    const shortArea = document.getElementById('short-history-' + sid);
    const fullArea = document.getElementById('full-history-' + sid);
    const moreBtn = document.getElementById('more-than-btn-' + sid);
    const imgTag = document.getElementById('detail-img-' + sid);

    imgTag.src = item.img;
    title.innerText = (currentLang === 'mm') ? item.t_mm : item.t_en;
    
    const fullText = (currentLang === 'mm') ? item.h_mm : item.h_en;
    shortArea.innerText = fullText.substring(0, 180) + "...";
    fullArea.innerText = fullText;

    fullArea.style.display = "none";
    moreBtn.style.display = "block";
    box.style.display = "block";

    // နေရာအမှန်ရောက်အောင် scroll လုပ်ပေးခြင်း
    setTimeout(() => {
        box.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 50);
}

        // "More Than" နှိပ်မှ အပြည့်အစုံပြခြင်း
        function showFullHistory(sid) {
            document.getElementById('full-history-' + sid).style.display = "block";
            document.getElementById('more-than-btn-' + sid).style.display = "none";
        }

        function showMain(el) {
            document.querySelectorAll('.content-section').forEach(s => s.style.display = "block");
            document.querySelectorAll('.explore-container').forEach(g => g.style.display = "none");
            setActive(el);
        }

        function showCategory(id, el) {
            document.querySelectorAll('.content-section').forEach(s => s.style.display = "none");
            const target = document.getElementById(id);
            if(target) target.style.display = "block";
            setActive(el);
        }

        function setActive(el) {
            document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
            el.classList.add('active');
        }
        // ပုံနှိပ်လိုက်လျှင် အချက်အလက်နှင့် ပုံပါပြခြင်း
        function showShortInfo(sid, idx) {
            const item = heritageData[sid]['others'][idx];
            const box = document.getElementById('info-box-' + sid);
            const title = document.getElementById('info-title-' + sid);
            const shortArea = document.getElementById('short-history-' + sid);
            const fullArea = document.getElementById('full-history-' + sid);
            const moreBtn = document.getElementById('more-than-btn-' + sid);

            // ၁။ ပုံအသေးကို ပြန်ထည့်ရန် (Dynamic Image Injection)
            // info-box ထဲမှာ image ပြဖို့ နေရာမရှိသေးရင် အသစ်ဆောက်ပေးမယ်
            let detailImg = document.getElementById('detail-img-' + sid);
            if (!detailImg) {
                detailImg = document.createElement('img');
                detailImg.id = 'detail-img-' + sid;
                detailImg.style.cssText = "width:100%; max-height:300px; object-fit:cover; border-radius:15px; margin-bottom:20px; border: 1px solid var(--gold-primary);";
                box.prepend(detailImg); // Title ရဲ့ အပေါ်မှာ ပုံကိုပြမယ်
            }
            detailImg.src = item.img;

            // ၂။ ဘာသာစကားအလိုက် Title နှင့် History ကို ပြောင်းလဲခြင်း
            const displayTitle = (currentLang === 'mm') ? item.t_mm : item.t_en;
            const fullText = (currentLang === 'mm') ? item.h_mm : item.h_en;

            title.innerText = displayTitle;
            
            // Short History (စာလုံး ၁၅၀ ဖြတ်ခြင်း)
            shortArea.innerText = fullText.substring(0, 150) + "...";
            fullArea.innerText = fullText;

            // Reset States
            fullArea.style.display = "none";
            moreBtn.style.display = "block";
            box.style.display = "block";
            box.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        // ဘာသာစကားပြောင်းရင် Info Box ထဲက စာတွေကိုပါ Update လုပ်ပေးဖို့ toggleLang ကို ပြင်မယ်
        function toggleLang() {
            currentLang = (currentLang === 'mm') ? 'en' : 'mm';
            document.querySelectorAll('.lang').forEach(el => {
                const text = el.getAttribute('data-' + currentLang);
                if(text) el.innerText = text;
            });

            // လက်ရှိဖွင့်ထားတဲ့ Info Box ရှိရင် Update လုပ်ပေးခြင်း
            document.querySelectorAll('.result-box').forEach(box => {
                if(box.style.display === "block") {
                    const sid = box.id.split('-').pop();
                    // ပြန် Refresh လုပ်ဖို့အတွက် လက်ရှိပြနေတဲ့ content ကို reference လုပ်ပြီး update လုပ်နိုင်ပါတယ်
                    // ဒါပေမယ့် ပိုကောင်းတာက user ကို နောက်တစ်ခါပြန်နှိပ်ခိုင်းတာထက် script ကနေ update လုပ်ပေးတာပါ
                }
            });
        }
    </script>
</body>
</html>