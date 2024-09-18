<?php
session_start();
include 'db.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Periksa apakah parameter 'id' ada di URL
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Pertama, ambil informasi produk untuk mendapatkan nama file gambar
    $sql = "SELECT image FROM products WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image_name = $row['image'];

        // Hapus file gambar dari server jika ada
        if (file_exists('images/' . $image_name)) {
            unlink('images/' . $image_name);
        }

        // Hapus produk dari database
        $sql = "DELETE FROM products WHERE id = '$id'";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Produk berhasil dihapus!'); window.location.href = 'dashboard.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus produk.'); window.location.href = 'dashboard.php';</script>";
        }
    } else {
        echo "<script>alert('Produk tidak ditemukan.'); window.location.href = 'dashboard.php';</script>";
    }
} else {
    header("Location: dashboard.php");
    exit;
}
?>
