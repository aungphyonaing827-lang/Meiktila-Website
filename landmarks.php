<?php 
session_start();
include 'db_connect.php'; 

// 1. GET THE CATEGORY
// If a user clicks a button, get that category. If not, default to 'Landmark'.
$selected_cat = isset($_GET['cat']) ? $_GET['cat'] : 'Landmark';

// Sanitize the input to prevent SQL injection
$selected_cat = mysqli_real_escape_string($conn, $selected_cat);

// 2. RUN THE QUERY
// We select where the category matches the clicked button
$query = "SELECT * FROM contents WHERE category = '$selected_cat' ORDER BY id DESC";
$result = mysqli_query($conn, $query);

// Define your categories (English DB Value => Myanmar Display Text)
$categories = [
    'Landmark'      => 'Market',
    'Gold Shop'     => 'ရွှေဆိုင်များ',
    'Cinema'        => 'ရုပ်ရှင်ရုံ',
    'Accommodation' => 'တည်းခိုရာနေရာများ',
    'Restaurant'    => 'စားသောက်ဆိုင်များ',
    'Beauty Salon'  => 'အလှပြင်ဆိုင်များ',
    'Gym'           => 'အားကစား',
    'Showroom'      => 'Showroom များ'
];

// Get the Myanmar title for the current selection to show in the Hero section
$current_title = isset($categories[$selected_cat]) ? $categories[$selected_cat] : $selected_cat;
?>

<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meiktila | <?php echo $current_title; ?></title>
    <link rel="stylesheet" href="CSS/style.css"> 
    <link rel="stylesheet" href="CSS/landmark_custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* CSS FOR THE CATEGORY BUTTONS (Pills) */
        .category-nav {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
            padding: 30px 20px;
            background-color: #f9f9f9;
        }

        .cat-btn {
            text-decoration: none;
            color: #555;
            background-color: #fff;
            padding: 10px 25px;
            border-radius: 50px; /* Makes them pill-shaped */
            border: 1px solid #ddd;
            font-weight: bold;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .cat-btn:hover {
            background-color: #eef;
            border-color: #ccf;
            transform: translateY(-2px);
        }

        /* The Active Button Style (Green like your screenshot) */
        .cat-btn.active {
            background-color: #00897b; /* Change this color to match your theme */
            color: #fff;
            border-color: #00897b;
            box-shadow: 0 4px 10px rgba(0, 137, 123, 0.3);
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<section class="edu-hero" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('Images/landmarkbg.jpg');">
    <h1>Explore: <?php echo $current_title; ?></h1>
    <p>Discover the best <?php echo strtolower($selected_cat); ?>s and locations in Meiktila.</p>
</section>

<div class="category-nav">
    <?php foreach($categories as $db_value => $mm_label): ?>
        <a href="landmarks.php?cat=<?php echo urlencode($db_value); ?>" 
           class="cat-btn <?php echo ($selected_cat == $db_value) ? 'active' : ''; ?>">
           <?php echo $mm_label; ?>
        </a>
    <?php endforeach; ?>
</div>

<div class="controls-section">
    <div class="search-container">
        <input type="text" id="landmarkSearch" onkeyup="filterLandmarks()" placeholder="Search by names...">
        <i class="fas fa-search search-icon"></i>
    </div>
</div>

<div class="edu-container">
    <section class="cards" id="landmarkGrid">
        <?php 
        if ($result && mysqli_num_rows($result) > 0):
            while($place = mysqli_fetch_assoc($result)): 
        ?>
        <div class="card landmark-item">
            <div class="imgBox">
                <img src="Images/<?php echo $place['image_path']; ?>" alt="<?php echo $place['title']; ?>">
            </div>
            <div class="content">
                <h2 class="landmark-name"><?php echo $place['title']; ?></h2>
                <p class="short">
                    <?php echo mb_substr($place['description'], 0, 100, "UTF-8"); ?>...
                </p>
                <button class="learn-btn"
                    data-title="<?php echo htmlspecialchars($place['title'], ENT_QUOTES); ?>"
                    data-desc="<?php echo htmlspecialchars($place['description'], ENT_QUOTES); ?>"
                    data-img="Images/<?php echo $place['image_path']; ?>"
                    onclick="openModal(this)">
                   View detail...
                </button>
            </div>
        </div>
        <?php 
            endwhile;
        else:
        ?>
            <div style="text-align:center; width:100%; padding: 40px; color: #666;">
                <h3>မတွေ့ရှိပါ</h3>
                <p>ဤကဏ္ဍ (<?php echo $current_title; ?>) အတွက် အချက်အလက်များ မထည့်ရသေးပါ။</p>
            </div>
        <?php endif; ?>
    </section>
</div>

<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">×</span>
        <img id="modalImg" src="">
        <h2 id="modalTitle"></h2>
        <div id="modalDescContainer">
            <p id="modalDesc"></p>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
// Modal Scripts
function openModal(btn){
    const modal = document.getElementById('modal');
    modal.classList.add('show');
    document.getElementById('modalTitle').innerText = btn.dataset.title;
    document.getElementById('modalDesc').innerText = btn.dataset.desc;
    document.getElementById('modalImg').src = btn.dataset.img;
}

function closeModal(){
    document.getElementById('modal').classList.remove('show');
}

window.onclick = function(event) {
    const modal = document.getElementById('modal');
    if (event.target == modal) {
        closeModal();
    }
}

// Search Filter (Filters the items currently on the screen)
function filterLandmarks() {
    let input = document.getElementById('landmarkSearch').value.toLowerCase();
    let cards = document.getElementsByClassName('landmark-item');

    for (let i = 0; i < cards.length; i++) {
        let name = cards[i].querySelector('.landmark-name').innerText.toLowerCase();
        cards[i].style.display = name.includes(input) ? "" : "none";
    }
}
</script>

</body>
</html>