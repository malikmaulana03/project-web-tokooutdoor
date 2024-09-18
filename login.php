<?php
session_start();
include 'db.php';

// Aktifkan pelaporan kesalahan
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Proses login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role']; // Asumsikan kolom 'role' ada di tabel users

        if ($row['role'] == 'admin') {
            header("Location: dashboard.php"); // Jika admin, arahkan ke dashboard
        } else {
            header("Location: index.php"); // Jika bukan admin, arahkan ke index
        }
        exit;
    } else {
        echo "<script>alert('Username atau password salah.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Toko Sewa Outdoor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Make sure your website is responsive -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 90%;
            max-width: 500px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            color: #2c3e50;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
        }

        input[type="text"],
        input[type="password"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-top: 5px;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s;
            margin-top: 20px;
        }

        button:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        .link {
            text-align: center;
            margin-top: 20px;
        }

        .link a {
            color: #2980b9;
            text-decoration: none;
        }

        .link a:hover {
            text-decoration: underline;
        }

        /* Media Queries for Mobile Devices */
        @media (max-width: 600px) {
            .container {
                margin: 20px;
                padding: 15px;
                box-shadow: none;
                width: 100%;
            }

            button {
                padding: 10px;
                margin-top: 15px;
            }

            h2 {
                font-size: 1.5em;
            }

            input[type="text"],
            input[type="password"] {
                font-size: 1em;
            }

            label {
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="POST" action="login.php">
            <label for="username">Username:</label>
            <input type="text" name="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Login</button>
        </form>
        <div class="link">
            <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
        </div>
    </div>
</body>
</html>
