<?php 
session_start();
include 'db_connect.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Education in Meiktila | Academic Hub</title>
    <link rel="stylesheet" href="CSS/style.css"> 
    <link rel="stylesheet" href="CSS/education.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<?php include 'header.php'; ?>

<section class="edu-hero">
    <style>
        .edu-hero {
            background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('Images/motarboard.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>
    <h1>Academic Hub of Myanmar</h1>
    <p>မိတ္ထီလာမြို့သည် ကမ္ဘာ့အဆင့်မှီ နည်းပညာ၊ စီးပွားရေးနှင့် လေကြောင်းဆိုင်ရာ အဖွဲ့အစည်းများ၏ အခြေဆိုက်ရာ မြို့ဖြစ်သည်။</p>
</section>

<div class="controls-section">
    <div class="search-container">
        <input type="text" id="eduSearch" onkeyup="combinedSearchFilter()" placeholder="Search for universities or schools...">
        <i class="fas fa-search search-icon"></i>
    </div>

    <div class="filter-container">
        <button class="filter-btn active" onclick="filterCategory('all', this)">အားလုံး</button>
        <button class="filter-btn" onclick="filterCategory('Aviation', this)">လေကြောင်း</button>
        <button class="filter-btn" onclick="filterCategory('Business', this)">စီးပွားရေး</button>
        <button class="filter-btn" onclick="filterCategory('Technology', this)">နည်းပညာ</button>
        <button class="filter-btn" onclick="filterCategory('Teaching', this)">သင်ကြားရေး</button>
        <button class="filter-btn" onclick="filterCategory('PublicSchool', this)">အစိုးရကျောင်း</button>
        <button class="filter-btn" onclick="filterCategory('PrivateSchool', this)">ကိုယ်ပိုင်ကျောင်း</button>
    </div>
</div>

<div class="edu-container">
    <div class="education-grid" id="eduGrid">
        <?php
        // Database Query ကို Category အကုန်ပါအောင် ပြင်ဆင်ထားပါတယ်
        $query = "SELECT * FROM contents 
                  WHERE category IN ('Aviation', 'Business', 'Technology', 'Teaching', 'PublicSchool', 'PrivateSchool') 
                  ORDER BY id DESC";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="uni-card <?php echo htmlspecialchars($row['category']); ?>">
                    <div class="uni-image">
                        <img src="Images/<?php echo $row['image_path']; ?>" alt="<?php echo $row['title']; ?>">
                        <span class="tag"><?php echo $row['category']; ?></span>
                    </div>
                    <div class="uni-content">
                        <h3 class="school-name"><?php echo $row['title']; ?></h3>
                        <p class="short-desc">
                            <?php 
                            $desc = strip_tags($row['description']);
                            if (mb_strlen($desc) > 150) {
                                echo mb_substr($desc, 0, 150, "UTF-8") . "...";
                            } else {
                                echo $desc;
                            }
                            ?>
                        </p>
                       
                        <button class="btn-info" onclick="toggleDetails('info-<?php echo $row['id']; ?>')">Know More</button>
                        
                        <div id="info-<?php echo $row['id']; ?>" class="detail-panel">
                            <?php if(!empty($row['location'])): ?>
                                <p class="edu-location">
                                    <i class="fas fa-map-marker-alt" style="color: #006a4e;"></i> 
                                    <strong>Location:</strong> <?php echo $row['location']; ?>
                                </p>
                                <hr>
                            <?php endif; ?>
                            <p><?php echo nl2br($row['description']); ?></p>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p style='text-align:center; width:100%;'>No education institutions found in database.</p>";
        }
        ?>

    </div>
</div>

<?php include 'footer.php'; ?>

<script>
let currentCategory = 'all';

function toggleDetails(id) {
    const panel = document.getElementById(id);
    const allPanels = document.querySelectorAll('.detail-panel');
    
    allPanels.forEach(p => {
        if(p.id !== id) p.style.display = 'none';
    });

    panel.style.display = (panel.style.display === 'block') ? 'none' : 'block';
}

function filterCategory(category, btn) {
    currentCategory = category;
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    combinedSearchFilter();
}

function combinedSearchFilter() {
    const searchTerm = document.getElementById('eduSearch').value.toLowerCase();
    const cards = document.querySelectorAll('.uni-card');

    cards.forEach(card => {
        const name = card.querySelector('.school-name').innerText.toLowerCase();
        const matchesSearch = name.includes(searchTerm);
        
        // ကတ်ပြားမှာပါတဲ့ class တွေထဲမှာ လက်ရှိ ရွေးထားတဲ့ category ပါ/မပါ စစ်ဆေးခြင်း
        const matchesCategory = (currentCategory === 'all' || card.classList.contains(currentCategory));

        if (matchesSearch && matchesCategory) {
            card.style.display = "flex";
        } else {
            card.style.display = "none";
        }
    });
}
</script>

</body>
</html>