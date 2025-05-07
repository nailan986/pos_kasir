<?php
include 'connection.php';
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <style>
        /* RESET */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #1f1c2c, #928dab);
    color: #ffffff;
    min-height: 100vh;
    padding: 40px 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* HEADER */
h1 {
    font-size: 42px;
    font-weight: 600;
    margin-bottom: 30px;
    text-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
}

h2 {
    font-size: 26px;
    margin: 40px 0 20px;
    color: #d3d3ff;
}

/* NAVIGATION */
nav {
    display: flex;
    gap: 15px;
    margin-bottom: 30px;
    flex-wrap: wrap;
    justify-content: center;
}

nav a {
    text-decoration: none;
    font-weight: 500;
    color: #fff;
    padding: 10px 20px;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(12px);
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
}

nav a:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-2px);
}

/* TABLE */
table {
    width: 90%;
    border-collapse: collapse;
    margin-top: 10px;
    border-radius: 16px;
    overflow: hidden;
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(10px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
}

th, td {
    padding: 16px 20px;
    text-align: center;
    font-size: 16px;
    color: #fff;
}

th {
    background: rgba(103, 58, 183, 0.8); /* ungu tajam */
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

tr:nth-child(even) {
    background-color: rgba(255, 255, 255, 0.04);
}

tr:hover {
    background-color: rgba(255, 255, 255, 0.12);
    transition: background-color 0.3s ease;
}

/* RESPONSIVE TABLE */
@media (max-width: 768px) {
    table, thead, tbody, th, td, tr {
        display: block;
    }

    table {
        width: 100%;
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
        left: 20px;
        font-weight: bold;
        text-align: left;
        color: #ddd;
    }

    th {
        display: none;
    }
}

    </style>
    <center><h1>HOME PAGE</h1>

    <nav>
        <a href="produk.php">Kelola Produk</a> 
        <a href="transaksi.php">menu transaksi</a> 
        <a href="profil.php">Profil akun</a> 
        <a href="laporan_harian.php">Laporan harian</a>
        <a href="laporan_bulanan.php">laporan bulanan</a>
    </nav>

    <h2>Daftar Produk</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Stok</th>
        </tr>

        <?php
        $query = "SELECT * FROM produk";
        $result = mysqli_query($koneksi, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['id_produk']}</td>";
            echo "<td>{$row['nama_produk']}</td>";
            echo "<td>Rp " . number_format($row['harga'], 2, ',', '.') . "</td>";
            echo "<td>{$row['stok']}</td>";
            echo "</tr>";
        }
        ?>
    </table>
    </center>
</body>
</html>
