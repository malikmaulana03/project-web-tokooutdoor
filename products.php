<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsive meta tag -->
    <title>Daftar Produk - Toko Sewa Outdoor</title>
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
            font-weight: bold;
            margin: 5px; /* Space between navbar items */
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .navbar a:hover {
            background-color: #1abc9c;
            border-radius: 4px;
            transform: scale(1.05);
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
            font-size: 28px;
            font-weight: bold;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .product {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .product img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 2px solid #ddd;
        }

        .product-info {
            padding: 15px;
            text-align: center;
        }

        .product-info h3 {
            margin: 0 0 10px 0;
            font-size: 20px;
            color: #2c3e50;
        }

        .product-info p {
            font-size: 14px;
            color: #7f8c8d;
            margin: 0 0 10px 0;
        }

        .product-info .price {
            font-size: 18px;
            font-weight: bold;
            color: #e74c3c;
        }

        .product-info a.button {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .product-info a.button:hover {
            background-color: #2980b9;
            transform: scale(1.05);
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

            .product-info a.button {
                padding: 8px 16px;
                font-size: 0.9em;
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

            .product-info a.button {
                padding: 6px 12px;
                font-size: 0.8em;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Daftar Produk - Toko Sewa Outdoor</h1>
    </header>
    <nav class="navbar">
        <a href="index.php">Beranda</a>
        <a href="products.php">Daftar Produk</a>
        <a href="login.php">Logout</a>
    </nav>
    <div class="container">
        <h2>Semua Produk</h2>
        <div class="products">
            <!-- Menampilkan produk dari database -->
            <?php
            include 'db.php';
            $sql = "SELECT * FROM products";
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
                    echo '<a href="product_detail.php?id=' . htmlspecialchars($row['id']) . '" class="button">Lihat Detail</a>';
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
