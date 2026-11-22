<!DOCTYPE html>
<html>

<head>
    <title>Login | Meiktila Project</title>
    <link rel="stylesheet" href="CSS/style.css">
    <style>
        .login-box {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        .login-box input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .btn-login {
            background: #006a4e;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <h2>Admin Login</h2>
        <form action="login_action.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>