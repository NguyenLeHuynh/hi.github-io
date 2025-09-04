<?php
require __DIR__ . "/../db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    // Mặc định role là "customer"
    $stmt = $pdo->prepare("INSERT INTO customers (username, email, password, role) VALUES (?, ?, ?, 'customer')");
    if ($stmt->execute([$username, $email, $password])) {
        echo "<script>alert('Đăng ký thành công! Hãy đăng nhập.'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Có lỗi xảy ra!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f5f6fa;
        }
        .register-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 350px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 6px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background: #1e7e34;
        }
    </style>
</head>
<body>
    <div class="register-box">
        <h2>Đăng ký</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Tài khoản" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <button type="submit">Đăng ký</button>
        </form>
        <a href="login.php">Đã có tài khoản? Đăng nhập</a>
    </div>
</body>
</html>
