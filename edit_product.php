<?php
session_start();
include 'db.php';

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Cek apakah ID produk dikirim melalui URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data produk berdasarkan ID
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if (!$product) {
        echo "Produk tidak ditemukan!";
        exit;
    }

    // Jika form di-submit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        // Cek apakah ada gambar baru yang di-upload
        if (!empty($_FILES['image']['name'])) {
            $image = $_FILES['image']['name'];
            $target_dir = "images/";
            $target_file = $target_dir . basename($image);

            // Pindahkan file gambar baru ke folder yang diinginkan
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                // Update produk dengan gambar baru
                $sql = "UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssdsi", $name, $description, $price, $image, $id);
            }
        } else {
            // Update produk tanpa mengganti gambar
            $sql = "UPDATE products SET name = ?, description = ?, price = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdi", $name, $description, $price, $id);
        }

        if ($stmt->execute()) {
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Error: " . $conn->error;
        }
    }
} else {
    echo "ID produk tidak diberikan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            color: #333;
        }
        .container {
            width: 90%;
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #3498db;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"], input[type="number"], textarea {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
        }
        input[type="file"] {
            padding: 10px;
        }
        .btn {
            padding: 10px 15px;
            background-color: #2ecc71;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #27ae60;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Produk</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="name">Nama Produk:</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>

            <label for="description">Deskripsi Produk:</label>
            <textarea name="description" id="description" rows="4" required><?php echo htmlspecialchars($product['description']); ?></textarea>

            <label for="price">Harga Produk:</label>
            <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>

            <label for="image">Gambar Produk (opsional):</label>
            <input type="file" name="image" id="image">

            <button type="submit" class="btn">Update Produk</button>
        </form>
    </div>
</body>
</html>
