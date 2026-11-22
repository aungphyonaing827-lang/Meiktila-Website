<?php
session_start();
include 'db_connect.php'; // သင့် database connection file အမည်နှင့် ကိုက်ညီအောင် စစ်ဆေးပါ

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Input များကို စစ်ဆေးပြီး လုံခြုံအောင် ပြုလုပ်ခြင်း
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    if (!empty($first_name) && !empty($email) && !empty($message)) {
        // SQL Injection ကာကွယ်ရန် Prepared Statement ကို သုံးခြင်းက ပိုကောင်းပါသည်
        $sql = "INSERT INTO contact_messages (first_name, last_name, email, message) 
                VALUES (?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $first_name, $last_name, $email, $message);

        if (mysqli_stmt_execute($stmt)) {
            $success_message = "ကျေးဇူးတင်ပါတယ် $first_name! သင်၏ အကြံပြုချက်ကို ကျွန်ုပ်တို့ လက်ခံရရှိပါသည်။";
        } else {
            $error_message = "အချက်အလက် ပေးပို့မှု မအောင်မြင်ပါ။ နောက်မှ ပြန်ကြိုးစားပါ။";
        }
        mysqli_stmt_close($stmt);
    } else {
        $error_message = "လိုအပ်သော အချက်အလက်များ ပြည့်စုံစွာ ဖြည့်စွက်ပါ။";
    }
}
?>

<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ဆက်သွယ်ရန် | Meiktila Guide</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Myanmar:wght@400;700&family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/style.css"> 

    <style>
        :root {
            --bg-color: #F8F7F4; 
            --text-dark: #1e293b;
            --text-grey: #64748b;
            --accent: #15803d;
            --white: #ffffff;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', 'Noto Sans Myanmar', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-dark);
            line-height: 1.6;
        }

        .wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 5%;
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 80px;
            align-items: start;
        }

        /* Form Styling */
        .form-header h3 {
            color: var(--accent);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }

        .form-header h1 {
            font-size: 2.5rem;
            margin-top: 0;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 20px;
            margin-bottom: 40px;
            font-weight: 800;
        }

        .input-row { display: flex; gap: 20px; margin-bottom: 30px; }
        .field { flex: 1; display: flex; flex-direction: column; }
        
        .field label {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-grey);
            margin-bottom: 10px;
        }

        .field input, .field textarea {
            background: transparent;
            border: none;
            border-bottom: 1px solid #cbd5e1;
            padding: 12px 0;
            font-size: 1rem;
            outline: none;
            transition: 0.3s;
            font-family: inherit;
        }

        .field input:focus, .field textarea:focus { border-bottom-color: var(--accent); }

        .submit-btn {
            background: var(--accent);
            color: white;
            padding: 18px 40px;
            border: none;
            border-radius: 50px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 20px;
            transition: 0.3s;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .submit-btn:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(21, 128, 61, 0.2); }

        /* Banners */
        .banner { padding: 20px; border-radius: 12px; margin-bottom: 30px; font-weight: 600; }
        .success-banner { background: #dcfce7; color: #166534; border-left: 5px solid #22c55e; }
        .error-banner { background: #fee2e2; color: #991b1b; border-left: 5px solid #ef4444; }

        /* Photo & Detail Section */
        .visual-container { position: sticky; top: 20px; }
        .photo-box img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .details { margin-top: 40px; }
        .detail-item { display: flex; gap: 15px; margin-bottom: 25px; align-items: flex-start; }
        .detail-item i { color: var(--accent); font-size: 1.2rem; margin-top: 5px; }
        .detail-item b { display: block; font-size: 1rem; color: var(--text-dark); }
        .detail-item p { margin: 0; color: var(--text-grey); font-size: 0.95rem; }

        @media (max-width: 900px) {
            .wrapper { grid-template-columns: 1fr; padding-top: 20px; }
            .visual-container { order: -1; }
            .form-header h1 { font-size: 2rem; }
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="wrapper">
    <section class="form-container">
        <div class="form-header">
            <h3>Contact Support</h3>
            <h1>ဆက်သွယ်မေးမြန်းရန်</h1>
        </div>

        <?php if ($success_message): ?>
            <div class="banner success-banner"><i class="fas fa-check-circle"></i> <?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <?php if ($error_message): ?>
            <div class="banner error-banner"><i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="contact.php" method="POST">
            <div class="input-row">
                <div class="field">
                    <label>ပထမအမည်</label>
                    <input type="text" name="first_name" placeholder="မောင်မောင်" required>
                </div>
                <div class="field">
                    <label>နောက်ဆုံးအမည်</label>
                    <input type="text" name="last_name" placeholder="Smith">
                </div>
            </div>

            <div class="field" style="margin-bottom: 30px;">
                <label>အီးမေးလ် လိပ်စာ</label>
                <input type="email" name="email" placeholder="example@mail.com" required>
            </div>

            <div class="field" style="margin-bottom: 30px;">
                <label>သင်၏ အကြံပြုချက်များ</label>
                <textarea name="message" rows="5" placeholder="ဤနေရာတွင် ရေးသားပေးပို့နိုင်ပါသည်..." required></textarea>
            </div>

            <button type="submit" class="submit-btn">
                Sent<i class="fas fa-paper-plane"></i>
            </button>
        </form>
    </section>

    <section class="visual-container">
        <div class="photo-box">
            <img src="Images/contact.jpg" alt="Contact Office" onerror="this.src='https://images.unsplash.com/photo-1423666639041-f56000c27a9a?auto=format&fit=crop&q=80&w=1000'">
        </div>

        <div class="details">
            <div class="detail-item">
                <i class="fas fa-map-marker-alt"></i>
                <div>
                    <b>တည်နေရာ</b>
                    <p>မိတ္ထီလာမြို့၊ မန္တလေးတိုင်းဒေသကြီး။</p>
                </div>
            </div>
            <div class="detail-item">
                <i class="fas fa-envelope"></i>
                <div>
                    <b>အီးမေးလ်</b>
                    <p>dannyapn0@gmail.com</p>
                </div>
            </div>
            <div class="detail-item">
                <i class="fas fa-phone-alt"></i>
                <div>
                    <b>ဖုန်းနံပါတ်</b>
                    <p>+95 9 781871540</p>
                </div>
            </div>
        </div>
    </section>
</div>

</body>
</html>