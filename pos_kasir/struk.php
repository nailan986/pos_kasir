<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['struk'])) {
    echo "Tidak ada data transaksi.";
    exit;
}

$struk = $_SESSION['struk'];
$id_penjualan = $struk['id_penjualan'];

$detail = mysqli_query($koneksi, "SELECT d.*, p.nama_produk, p.harga FROM detail_penjualan d JOIN produk p ON d.id_produk = p.id_produk WHERE d.id_penjualan = '$id_penjualan'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Struk Transaksi</title>
</head>
<body>
    <style>
        <style>
    /* ===== RESET DAN GLOBAL ===== */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #1e3c72, #2a5298); /* Biru Tua ke Biru Cerah */
        color: #fff;
        padding: 30px;
        min-height: 100vh;
    }

    h2 {
        margin-bottom: 20px;
        text-align: center;
        color: #ffeb3b;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
    }

    p {
        color: #fff;
        font-size: 16px;
        margin-bottom: 15px;
    }

    a {
        color: #ffe082;
        text-decoration: none;
        font-weight: bold;
        transition: color 0.3s;
    }

    a:hover {
        color: #fff176;
    }

    /* ===== TABEL STRUK TRANSAKSI ===== */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 30px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    th, td {
        padding: 12px 16px;
        text-align: left;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
    }

    th {
        background-color: rgba(0, 0, 0, 0.3);
        font-size: 16px;
    }

    td {
        font-size: 15px;
    }

    tr:last-child td {
        border-bottom: none;
    }

    tr:hover {
        background: rgba(255, 255, 255, 0.05);
    }

    /* ===== BARIS TOTAL DAN DISKON ===== */
    td[colspan="3"] {
        font-weight: bold;
        color: #ffeb3b;
    }

    td {
        color: #ffffff;
    }

    td strong {
        font-size: 16px;
    }

    /* ===== TOMBOL CETAK ===== */
    button {
        padding: 12px 18px;
        background-color: #ffca28;
        color: #222;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        font-size: 16px;
        margin-top: 30px;
        transition: background-color 0.3s, transform 0.2s;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    button:hover {
        background-color: #ffe082;
        transform: scale(1.05);
    }

    /* ===== MEDIA QUERY RESPONSIVE ===== */
    @media (max-width: 768px) {
        body {
            padding: 15px;
        }

        h2 {
            font-size: 20px;
        }

        table {
            font-size: 14px;
        }

        button {
            width: 100%;
        }
    }
</style>

    </style>
    <h2>STRUK TRANSAKSI</h2>
    <p>Tanggal: <?= $struk['tanggal'] ?></p>
    <p>Kasir: <?= $struk['nama_kasir'] ?></p>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($detail)) { ?>
            <tr>
                <td><?= $row['nama_produk'] ?></td>
                <td>Rp<?= $row['harga'] ?></td>
                <td><?= $row['jumlah_produk'] ?></td>
                <td>Rp<?= $row['subtotal'] ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="3"><strong>Total</strong></td>
            <td>Rp<?= $struk['total'] ?></td>
        </tr>
        <tr>
            <td colspan="3">Diskon</td>
            <td>Rp<?= $struk['diskon'] ?></td>
        </tr>
        <tr>
            <td colspan="3">Total Bayar</td>
            <td>Rp<?= $struk['total_setelah_diskon'] ?></td>
        </tr>
        <tr>
            <td colspan="3">Uang Dibayar</td>
            <td>Rp<?= $struk['bayar'] ?></td>
        </tr>
        <tr>
            <td colspan="3">Kembalian</td>
            <td>Rp<?= $struk['kembalian'] ?></td>
        </tr>
    </table>

    <br>
    <button onclick="window.print()">Cetak laporan harian</button>
    <a href="transaksi.php">Kembali ke Transaksi</a>
</body>
</html>
