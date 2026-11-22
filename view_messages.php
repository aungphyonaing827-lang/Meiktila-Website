<?php
session_start();
include 'db_connect.php';

// Delete Logic
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM contact_messages WHERE id=$id");
    header("Location: view_messages.php");
}

$result = mysqli_query($conn, "SELECT * FROM contact_messages ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Messages</title>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; padding: 40px; }
        .admin-container { max-width: 1000px; background: white; margin: auto; padding: 20px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; }
        th { background: #2d8a56; color: white; }
        .btn-del { color: #e74c3c; text-decoration: none; font-weight: bold; }
        .btn-del:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="admin-container">
    <h2>Admin Dashboard - စာတိုများ စီမံခန့်ခွဲရန်</h2>
    <table>
        <thead>
            <tr>
                <th>အမည်</th>
                <th>အီးမေးလ်</th>
                <th>စာသား</th>
                <th>နေ့စွဲ</th>
                <th>လုပ်ဆောင်ချက်</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['message']; ?></td>
                <td><small><?php echo $row['created_at']; ?></small></td>
                <td><small><?php echo $row['created_at'] ?? 'နေ့စွဲမရှိပါ'; ?></small></td>
                <td>
                    <a href="?delete=<?php echo $row['id']; ?>" class="btn-del" onclick="return confirm('ဖျက်ရန် သေချာပါသလား?')">ဖျက်မည်</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>