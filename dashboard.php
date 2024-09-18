<?php
session_start();
include 'db.php';

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Toko Sewa Outdoor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
            color: #333;
            transition: background-color 0.3s, color 0.3s;
        }
        header {
            background-color: #3498db;
            color: white;
            padding: 15px;
            text-align: center;
            position: relative;
        }
        .dark-mode header {
            background-color: #1b2a49;
        }
        .dark-mode body {
            background-color: #2c3e50;
            color: #ecf0f1;
        }
        .container {
            width: 90%;
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            transition: background-color 0.3s;
        }
        .dark-mode .container {
            background-color: #34495e;
        }
        h2, h3 {
            color: #2c3e50;
            text-align: center;
        }
        .dark-mode h2, .dark-mode h3 {
            color: #ecf0f1;
        }
        .navbar {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .navbar a {
            text-decoration: none;
            padding: 10px 20px;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-add {
            background-color: #2ecc71;
        }
        .btn-add:hover {
            background-color: #27ae60;
            transform: scale(1.05);
        }
        .btn {
            background-color: #e74c3c;
            border: none;
            border-radius: 5px;
            padding: 8px 16px;
            font-size: 14px;
            cursor: pointer;
            color: white;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
        }
        .btn:hover {
            background-color: #c0392b;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transform: scale(1.05);
        }
        .btn-delete {
            background: linear-gradient(135deg, #ff6b6b, #e74c3c);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 16px;
            cursor: pointer;
            transition: background 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
        }
        .btn-delete:hover {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transform: scale(1.05);
        }
        .table-wrapper {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            transition: background-color 0.3s, color 0.3s;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        .dark-mode th {
            background-color: #1b2a49;
            color: #ecf0f1;
        }
        .dark-mode td {
            background-color: #2c3e50;
            color: #ecf0f1;
        }
        .dark-mode tr:nth-child(even) td {
            background-color: #34495e;
        }
        .dark-mode tr:nth-child(odd) td {
            background-color: #2c3e50;
        }
        .image-preview {
            width: 100px;
            border-radius: 4px;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .toggle-dark-mode {
            position: absolute;
            top: 15px;
            right: 20px;
            background-color: #fff;
            border: none;
            color: #333;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s, transform 0.2s ease;
            font-size: 16px;
        }
        .dark-mode .toggle-dark-mode {
            background-color: #333;
            color: #fff;
        }
        .dark-mode .toggle-dark-mode .fa-sun {
            display: none;
        }
        .toggle-dark-mode .fa-moon {
            display: none;
        }
        .dark-mode .toggle-dark-mode .fa-moon {
            display: inline;
        }
        .toggle-dark-mode .fa-sun {
            display: inline;
        }
        @media (max-width: 768px) {
            .container {
                width: 100%;
                margin: 20px 0;
                border-radius: 0;
            }
            .navbar a {
                width: 100%;
                text-align: center;
                margin: 5px 0;
            }
            table, th, td {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Dashboard Admin</h1>
        <button class="toggle-dark-mode" onclick="toggleDarkMode()">
            <i class="fas fa-sun"></i>
            <i class="fas fa-moon"></i>
        </button>
    </header>
    <div class="container">
        <h2>Selamat datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <div class="navbar">
            <a href="add_product.php" class="btn btn-add">Tambah Produk</a>
            <a href="logout.php" class="btn">Logout</a>
        </div>

        <h3>Daftar Produk</h3>
        <div class="table-wrapper">
            <table>
                <tr>
                    <th>Nama Produk</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
                <?php
                $sql = "SELECT * FROM products";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                        echo "<td>Rp " . number_format($row['price'], 2, ',', '.') . "</td>";
                        echo "<td><img src='images/" . htmlspecialchars($row['image']) . "' class='image-preview'></td>";
                        echo "<td class='action-buttons'>
                    <a href='edit_product.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-edit'>Edit</a>
                    <a href='delete_product.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-delete' onclick=\"return confirm('Anda yakin ingin menghapus produk ini?');\">Hapus</a>
                  </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada produk.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>

    <script>
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
        }
    </script>
</body>
</html>
