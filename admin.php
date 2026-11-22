<?php
session_start();
include 'db_connect.php';

// ဒါလေး ထည့်လိုက်ရင် $result Error ပျောက်သွားပါလိမ့်မယ်
$result = mysqli_query($conn, "SELECT * FROM contents ORDER BY id DESC");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Manage Content</title>
    <link rel="stylesheet" href="CSS/style.css">
    <style>
        .admin-container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            font-family: sans-serif;
        }

        .btn-add {
            display: inline-block;
            background-color: #006a4e;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .btn-edit {
            color: #2980b9;
            text-decoration: none;
            margin-right: 10px;
        }

        .btn-delete {
            color: #c0392b;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div style="text-align: right; margin-bottom: 20px;">

        <a href="logout.php" style="color: red; margin-left: 15px; text-decoration: none;">Logout</a>
    </div>

    <div class="admin-container">
        <h2>Admin Dashboard - Manage Content</h2>

        <a href="add_content.php" class="btn-add">Add New School/University/Landmark/Culture_Food/Transportation</a><a href="view_messages.php"><button type="text" value="view">View user's suggestion</button></a>

        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query အလုပ်လုပ်မလုပ် စစ်ဆေးပြီးမှ Loop ပတ်မယ်
                if ($result && mysqli_num_rows($result) > 0):
                    while ($row = mysqli_fetch_assoc($result)):
                ?>
                        <tr>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['category']; ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                                <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('ဖျက်မှာ သေချာလား?')">Delete</a>
                            </td>
                        </tr>
                    <?php
                    endwhile;
                else:
                    ?>
                    <tr>
                        <td colspan="3" style="text-align:center;">အချက်အလက် မရှိသေးပါ။ အသစ်ထည့်ရန် ခလုတ်ကို နှိပ်ပါ။</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>

</html>