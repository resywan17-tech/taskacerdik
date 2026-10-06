<?php
session_start();

$error = "";

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Username dan password admin
    $admin_username = "admin";
    $admin_password = "87654321";

    if ($username === $admin_username && $password === $admin_password) {

        $_SESSION['admin'] = true;
        $_SESSION['admin_username'] = $username;

        header("Location: admin.php");
        exit;

    } else {
        $error = "Username atau kata laluan salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | TASKA CERDIK</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #e8f8ff, #fff4df);
        }

        .login-box {
            width: 380px;
            background: white;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .login-box h2 {
            text-align: center;
            color: #2c7a7b;
            margin-bottom: 10px;
        }

        .login-box p {
            text-align: center;
            color: #777;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        button {
            width: 100%;
            padding: 13px;
            margin-top: 25px;
            border: none;
            border-radius: 8px;
            background: #2c7a7b;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #225e60;
        }

        .error {
            margin-top: 15px;
            text-align: center;
            color: red;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #555;
        }
    </style>
</head>

<body>

<div class="login-box">

    <h2>🔐 ADMIN LOGIN</h2>

    <p>Log masuk untuk mengakses panel pentadbir</p>

    <form method="post">

        <label>Username</label>
        <input type="text" name="username" required>

        <label>Kata Laluan</label>
        <input type="password" name="password" required>

        <button type="submit" name="login">
            🔑 Log Masuk
        </button>

    </form>

    <?php if ($error != "") { ?>
        <div class="error">
            <?php echo $error; ?>
        </div>
    <?php } ?>

    <a href="index.html" class="back">
        ← Kembali ke Laman Utama
    </a>

</div>

</body>
</html>