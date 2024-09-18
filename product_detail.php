<?php
session_start();
include 'db.php';

// Aktifkan pelaporan kesalahan
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ambil ID produk dari URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data produk dari database
$sql = "SELECT * FROM products WHERE id = $product_id";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $product = $result->fetch_assoc();
} else {
    echo "Produk tidak ditemukan.";
    exit;
}

// Cek apakah pengguna login
$is_logged_in = isset($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsive meta tag -->
    <title>Detail Produk - Toko Sewa Outdoor</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f4f8;
            color: #333;
        }

        header {
            background-color: #34495e; /* Modern color */
            color: white;
            padding: 20px;
            text-align: center;
            border-bottom: 5px solid #2c3e50;
        }

        .navbar {
            display: flex;
            flex-wrap: wrap; /* Make navbar responsive */
            justify-content: center;
            background-color: #2c3e50;
            padding: 10px 0;
        }

        .navbar a {
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            font-weight: bold;
            margin: 5px; /* Space between navbar items */
            transition: background-color 0.3s ease;
        }

        .navbar a:hover {
            background-color: #1abc9c;
            border-radius: 4px;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .product-detail {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .product-detail img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .product-info {
            text-align: center;
            margin-top: 20px;
        }

        .product-info h3 {
            margin: 0;
            font-size: 24px;
            color: #2c3e50;
        }

        .product-info p {
            margin: 10px 0;
            font-size: 16px;
            color: #7f8c8d;
        }

        .product-info .price {
            font-size: 20px;
            font-weight: bold;
            color: #e74c3c;
            margin-top: 10px;
        }

        .action-buttons {
            margin-top: 20px;
            text-align: center;
        }

        .action-buttons a {
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            background-color: #27ae60;
            transition: background-color 0.3s ease, transform 0.2s;
        }

        .action-buttons a:hover {
            background-color: #229954;
            transform: scale(1.05);
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        footer {
            background-color: #34495e;
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 20px;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .navbar a {
                padding: 8px 15px;
                margin: 3px;
                font-size: 0.9em;
            }

            .container {
                padding: 15px;
            }

            .product-info h3 {
                font-size: 1.5em;
            }

            .product-info p {
                font-size: 0.95em;
            }

            .product-info .price {
                font-size: 1.1em;
            }

            .action-buttons a {
                padding: 10px 20px;
            }

            footer {
                padding: 10px;
                font-size: 0.9em;
            }
        }

        @media (max-width: 480px) {
            .navbar a {
                padding: 6px 10px;
                margin: 2px;
                font-size: 0.8em;
            }

            .product-info h3 {
                font-size: 1.3em;
            }

            .product-info p {
                font-size: 0.9em;
            }

            .product-info .price {
                font-size: 1em;
            }

            .action-buttons a {
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Detail Produk - Toko Sewa Outdoor</h1>
    </header>
    <nav class="navbar">
        <a href="index.php">Beranda</a>
        <a href="products.php">Daftar Produk</a>
        <?php if ($is_logged_in): ?>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Admin</a>
        <?php endif; ?>
    </nav>
    <div class="container">
        <h2>Detail Produk</h2>
        <div class="product-detail">
            <?php if (isset($product['image'])): ?>
                <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            <?php endif; ?>
            <div class="product-info">
                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                <p><strong>Deskripsi:</strong> <?php echo htmlspecialchars($product['description']); ?></p>
                <p class="price">Rp <?php echo number_format($product['price'], 2, ',', '.'); ?></p>
            </div>
        </div>
        <div class="action-buttons">
        <?php if ($is_logged_in): ?>
    <a href="checkout.php?id=<?php echo $product_id; ?>">Sewa Sekarang</a>
<?php endif; ?>
        </div>
        <div class="back-link">
            <a href="products.php">Kembali ke daftar produk</a>
        </div>
    </div>
    <footer>
        &copy; 2024 Toko Sewa Peralatan Outdoor. All rights reserved.
    </footer>
</body>
</html>
