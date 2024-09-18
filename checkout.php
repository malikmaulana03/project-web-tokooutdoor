<?php
session_start();
include 'db.php';

// Aktifkan pelaporan kesalahan
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cek apakah pengguna login
$is_logged_in = isset($_SESSION['username']);

if (!$is_logged_in) {
    header("Location: login.php");
    exit;
}

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Toko Sewa Outdoor</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f4f8;
            color: #333;
        }

        header {
            background-color: #34495e;
            color: white;
            padding: 20px;
            text-align: center;
            border-bottom: 5px solid #2c3e50;
        }

        .container {
            width: 90%;
            max-width: 800px;
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

        .product-info {
            text-align: center;
            margin-bottom: 20px;
        }

        .product-info img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
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
        }

        .payment-method {
            margin-top: 30px;
        }

        .payment-method label {
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .payment-method input {
            margin-right: 10px;
        }

        .submit-button, .back-button {
            text-align: center;
            margin-top: 20px;
        }

        .submit-button input, .back-button a {
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            background-color: #27ae60;
            transition: background-color 0.3s ease, transform 0.2s;
            border: none;
            cursor: pointer;
            display: inline-block;
        }

        .back-button a {
            background-color: #3498db;
            text-decoration: none;
        }

        .submit-button input:hover, .back-button a:hover {
            background-color: #229954;
            transform: scale(1.05);
        }

        .back-button a:hover {
            background-color: #2980b9;
        }

        footer {
            background-color: #34495e;
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Checkout - Toko Sewa Outdoor</h1>
    </header>
    <div class="container">
        <h2>Checkout</h2>
        <div class="product-info">
            <?php if (isset($product['image'])): ?>
                <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            <?php endif; ?>
            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
            <p class="price">Rp <?php echo number_format($product['price'], 2, ',', '.'); ?></p>
        </div>
        <form action="process_payment.php" method="POST" onsubmit="return showThankYouPopup()">
            <div class="payment-method">
                <label for="payment-method">Pilih Metode Pembayaran:</label>
                <input type="radio" id="dana" name="payment_method" value="dana" required>
                <label for="dana">DANA</label><br>
                <input type="radio" id="gopay" name="payment_method" value="gopay" required>
                <label for="gopay">GoPay</label>
            </div>
            <div class="submit-button">
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                <input type="submit" value="Bayar Sekarang">
            </div>
        </form>
        <div class="back-button">
            <a href="products.php">Kembali ke Daftar Produk</a>
        </div>
    </div>
    <footer>
        &copy; 2024 Toko Sewa Peralatan Outdoor. All rights reserved.
    </footer>

    <script>
        function showThankYouPopup() {
            alert("Terimakasih, pembayaran anda sedang kami proses.");
            window.location.href = "index.php"; // Redirect ke halaman dashboard setelah pembayaran
            return false; // Mencegah form untuk submit secara default
        }
    </script>
</body>
</html>
