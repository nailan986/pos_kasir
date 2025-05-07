<?php
include 'connection.php';

// Tambah Produk
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    mysqli_query($koneksi, "INSERT INTO produk (nama_produk, harga, stok) VALUES ('$nama', '$harga', '$stok')");
    header("Location: produk.php");
    exit;
}

// Update Produk
if (isset($_POST['update'])) {
    $id = $_POST['id_produk'];
    $nama = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    mysqli_query($koneksi, "UPDATE produk SET nama_produk='$nama', harga='$harga', stok='$stok' WHERE id_produk='$id'");
    header("Location: produk.php");
    exit;
}

// Hapus Produk
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM produk WHERE id_produk='$id'");
    header("Location: produk.php");
    exit;
}

// Edit Produk
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$id'");
    $editData = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <title>Manajemen Produk</title>
</head>
<body>
    <style>
        /* Google Font */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

:root {
    --bg-gradient: linear-gradient(135deg, #1a1a2e, #16213e);
    --glass-bg: rgba(255, 255, 255, 0.06);
    --border-color: rgba(255, 255, 255, 0.15);
    --primary: #6c5ce7;
    --primary-light: #a29bfe;
    --text: #ffffff;
    --text-muted: #dfe6e9;
}

/* Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', sans-serif;
    background: var(--bg-gradient);
    color: var(--text);
    padding: 40px 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* Header */
h1 {
    font-size: 40px;
    margin-bottom: 20px;
    color: var(--primary-light);
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.4);
}

h2 {
    font-size: 26px;
    margin: 30px 0 20px;
    color: var(--text-muted);
}

/* Link Buttons */
a {
    text-decoration: none;
    color: var(--primary-light);
    padding: 8px 18px;
    margin: 8px;
    border-radius: 8px;
    background: var(--glass-bg);
    border: 1px solid var(--border-color);
    transition: 0.3s;
    backdrop-filter: blur(8px);
    display: inline-block;
}

a:hover {
    background: var(--primary);
    color: #fff;
}

/* Form Container */
form {
    background: var(--glass-bg);
    border: 1px solid var(--border-color);
    padding: 25px;
    border-radius: 16px;
    width: 90%;
    max-width: 500px;
    margin: 20px 0;
    backdrop-filter: blur(10px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
}

/* Form Fields */
form input[type="text"],
form input[type="number"] {
    width: 100%;
    padding: 12px 16px;
    margin: 10px 0;
    border: 1px solid var(--border-color);
    border-radius: 10px;
    background-color: rgba(255, 255, 255, 0.05);
    color: var(--text);
    font-size: 15px;
    outline: none;
    transition: 0.3s;
}

form input:focus {
    border-color: var(--primary);
}

/* Form Button */
form button {
    background-color: var(--primary);
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 600;
    transition: background 0.3s ease;
    margin-top: 10px;
}

form button:hover {
    background-color: #7c6ff0;
}

/* Table Style */
table {
    width: 100%;
    max-width: 1000px;
    margin-top: 30px;
    border-collapse: collapse;
    background: var(--glass-bg);
    border-radius: 16px;
    overflow: hidden;
    backdrop-filter: blur(6px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
}

th, td {
    padding: 16px;
    text-align: center;
    font-size: 15px;
}

th {
    background-color: var(--primary);
    color: white;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

td {
    border-top: 1px solid var(--border-color);
    color: var(--text-muted);
}

tr:hover {
    background-color: rgba(255, 255, 255, 0.08);
    transition: background-color 0.3s ease;
}

/* Responsive Table */
@media (max-width: 768px) {
    table, thead, tbody, th, td, tr {
        display: block;
    }

    tr {
        margin-bottom: 20px;
    }

    td {
        text-align: right;
        padding-left: 50%;
        position: relative;
    }

    td::before {
        content: attr(data-label);
        position: absolute;
        left: 15px;
        font-weight: bold;
        color: #ccc;
        text-align: left;
    }

    th {
        display: none;
    }
}

    </style>
    <h1>Manajemen Produk</h1>
    <a href="index.php">Kembali ke Dashboard</a>
    <a href="transaksi.php">transaksi</a>

    <h2><?= $editData ? "Edit Produk" : "Tambah Produk" ?></h2>
    <form method="POST">
        <input type="hidden" name="id_produk" value="<?= $editData['id_produk'] ?? '' ?>">
        Nama Produk: <input type="text" name="nama_produk" value="<?= $editData['nama_produk'] ?? '' ?>" required><br>
        Harga: <input type="number" name="harga" value="<?= $editData['harga'] ?? '' ?>" required><br>
        Stok: <input type="number" name="stok" value="<?= $editData['stok'] ?? '' ?>" required><br>
        <button type="submit" name="<?= $editData ? 'update' : 'tambah' ?>">
            <?= $editData ? 'Update' : 'Tambah' ?>
        </button>
        <?php if ($editData): ?>
            <a href="produk.php">Batal Edit</a>
        <?php endif; ?>
    </form>

    <h2>Daftar Produk</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
        <?php
        $result = mysqli_query($koneksi, "SELECT * FROM produk");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['id_produk']}</td>
                    <td>{$row['nama_produk']}</td>
                    <td>Rp " . number_format($row['harga'], 2, ',', '.') . "</td>
                    <td>{$row['stok']}</td>
                    <td>
                        <a href='produk.php?edit={$row['id_produk']}'>Edit</a> |
                        <a href='produk.php?hapus={$row['id_produk']}' onclick=\"return confirm('Hapus produk ini?')\">Hapus</a>
                    </td>
                </tr>";
        }
        ?>
    </table>
</body>
</html>
