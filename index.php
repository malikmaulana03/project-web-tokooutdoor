<?php
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Optionally, regenerate session ID to prevent session fixation attacks
session_regenerate_id(true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Ensure the page is responsive -->
    <title>Toko Sewa Peralatan Outdoor</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f4f8;
            color: #333;
        }

        a {
            text-decoration: none;
        }

        header {
            background-color: #34495e; /* Updated color for a modern look */
            color: white;
            padding: 20px;
            text-align: center;
        }

        .navbar {
            display: flex;
            flex-wrap: wrap; /* Make navbar responsive */
            justify-content: center;
            background-color: #2c3e50; /* Slightly darker shade */
            padding: 10px 0;
        }

        .navbar a {
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            margin: 5px;
        }

        .navbar a:hover {
            background-color: #1abc9c; /* Updated hover color */
            border-radius: 4px; /* Rounded corners for hover */
        }

        .container {
            width: 90%;
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .hero {
            text-align: center;
            padding: 60px 20px; /* Increased padding */
            background-color: #1abc9c; /* Updated color */
            color: white;
            border-radius: 8px;
        }

        .hero h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .hero p {
            font-size: 1.2em;
            margin-top: 10px;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .product {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth hover effect */
        }

        .product:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); /* Enhanced hover effect */
        }

        .product img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .product-info {
            padding: 15px;
        }

        .product-info h3 {
            margin: 0 0 10px 0;
            font-size: 1.2em;
            color: #2c3e50;
        }

        .product-info p {
            font-size: 0.9em;
            color: #7f8c8d;
            margin: 0 0 10px 0;
        }

        .product-info .price {
            font-size: 1em;
            font-weight: bold;
            color: #e74c3c;
        }

        footer {
            background-color: #34495e; /* Updated footer color */
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 20px;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2em;
            }

            .hero p {
                font-size: 1em;
            }

            .products {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 15px;
            }

            .product img {
                height: 150px;
            }

            footer {
                padding: 10px;
                font-size: 0.9em;
            }
        }

        @media (max-width: 480px) {
            .navbar a {
                padding: 8px 10px;
                margin: 2px;
                font-size: 0.9em;
            }

            .hero {
                padding: 40px 15px;
            }

            .container {
                padding: 15px;
            }

            .product-info h3 {
                font-size: 1em;
            }

            .product-info p {
                font-size: 0.8em;
            }

            .product-info .price {
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Selamat Datang di Toko Sewa Peralatan Outdoor</h1>
    </header>
    <nav class="navbar">
        <a href="index.php">Beranda</a>
        <a href="products.php">Daftar Produk</a>
        <a href="logout.php">Logout</a>
    </nav>
    <div class="container">
        <div class="hero">
            <h1>Temukan Peralatan Outdoor Terbaik!</h1>
            <p>Sewa peralatan outdoor untuk petualangan Anda berikutnya dengan harga terbaik.</p>
        </div>

        <h2>Produk Unggulan</h2>
        <div class="products">
            <!-- Ini adalah contoh produk, yang sebenarnya dapat diambil dari database -->
            <?php
            include 'db.php';
            $sql = "SELECT * FROM products LIMIT 4";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="product">';
                    echo '<a href="product_detail.php?id=' . htmlspecialchars($row['id']) . '">';
                    echo '<img src="images/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">';
                    echo '<div class="product-info">';
                    echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                    echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                    echo '<p class="price">Rp ' . number_format($row['price'], 2, ',', '.') . '</p>';
                    echo '</div>';
                    echo '</a>';
                    echo '</div>';
                }
            } else {
                echo '<p>Tidak ada produk yang tersedia saat ini.</p>';
            }
            ?>
        </div>
    </div>
    <footer>
        &copy; 2024 Malik Toko Sewa Peralatan Outdoor. All rights reserved.
    </footer>
</body>
</html>
