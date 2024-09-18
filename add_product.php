<?php
session_start();
include 'db.php';

// Aktifkan pelaporan kesalahan
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    
    // Menangani upload gambar
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];
        $image_error = $_FILES['image']['error'];

        // Memeriksa tipe file gambar yang diizinkan
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        if (in_array($image_extension, $allowed_extensions)) {
            if ($image_size <= 5000000) { // Ukuran maksimum 5MB
                $new_image_name = uniqid('', true) . '.' . $image_extension;
                $image_destination = 'images/' . $new_image_name;

                // Periksa apakah folder 'images' ada dan bisa ditulis
                if (!file_exists('images')) {
                    mkdir('images', 0777, true);
                }

                if (move_uploaded_file($image_tmp_name, $image_destination)) {
                    // Simpan produk dan nama gambar ke database
                    $sql = "INSERT INTO products (name, description, price, image) VALUES ('$name', '$description', '$price', '$new_image_name')";

                    if ($conn->query($sql) === TRUE) {
                        echo "<script>alert('Produk berhasil ditambahkan!'); window.location.href = 'dashboard.php';</script>";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                } else {
                    echo "<script>alert('Gagal mengunggah gambar. Silakan coba lagi.');</script>";
                }
            } else {
                echo "<script>alert('Ukuran gambar terlalu besar (maksimal 5MB).');</script>";
            }
        } else {
            echo "<script>alert('Format gambar tidak diizinkan. Hanya JPG, JPEG, PNG, dan GIF yang diperbolehkan.');</script>";
        }
    } else {
        echo "<script>alert('Harap unggah gambar yang valid.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk - Toko Sewa Outdoor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        .navbar {
            text-align: center;
            margin-bottom: 20px;
        }
        .navbar a {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.2s;
        }
        .navbar a:hover {
            background-color: #2980b9;
            transform: scale(1.05);
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
        textarea,
        input[type="file"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-top: 5px;
        }
        button {
            padding: 12px;
            background-color: #2ecc71;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s;
            margin-top: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        button:hover {
            background-color: #27ae60;
            transform: scale(1.05);
        }
        button:active {
            transform: scale(0.98);
        }
        button i {
            margin-right: 8px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                width: 95%;
                margin: 20px auto;
                padding: 15px;
            }

            input[type="text"],
            textarea,
            input[type="file"],
            button {
                font-size: 16px;
            }

            button {
                padding: 10px;
                font-size: 16px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="navbar">
            <a href="dashboard.php"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</a>
        </div>
        <h2>Tambah Produk</h2>
        <form method="POST" action="add_product.php" enctype="multipart/form-data">
            <label for="name">Nama Produk:</label>
            <input type="text" name="name" required>
            <label for="description">Deskripsi:</label>
            <textarea name="description" required></textarea>
            <label for="price">Harga:</label>
            <input type="text" name="price" required>
            <label for="image">Gambar:</label>
            <input type="file" name="image" required>
            <button type="submit"><i class="fas fa-plus-circle"></i> Tambah Produk</button>
        </form>
    </div>
</body>
</html>
