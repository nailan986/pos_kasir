<?php
include 'connection.php';

// Ambil data laporan bulanan dari tabel laporan_harian
$query = "
    SELECT 
        DATE_FORMAT(tanggal_penjualan, '%Y-%m') AS bulan,
        SUM(total_penjualan) AS total_bulanan
    FROM laporan_harian
    GROUP BY bulan
    ORDER BY bulan DESC
";

$data = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Bulanan</title>
</head>
<body>
<style>
    /* ===== RESET DAN GLOBAL ===== */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Arial', sans-serif;
        background: linear-gradient(135deg, #3f51b5, #9c27b0); /* Gradasi biru ke ungu */
        color: #fff;
        padding: 30px;
        min-height: 100vh;
    }

    a {
        color: #ffeb3b;
        text-decoration: none;
        font-weight: bold;
        transition: color 0.3s;
    }

    a:hover {
        color: #fff176;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #ffeb3b;
        font-size: 24px;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    }

    /* ===== TABEL LAPORAN BULANAN ===== */
    table {
        width: 100%;
        border-collapse: collapse;
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

    tr:hover {
        background: rgba(255, 255, 255, 0.05);
    }

    /* ===== TOMBOL CETAK ===== */
    button {
        padding: 12px 18px;
        background-color: #ffeb3b;
        color: #222;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        font-size: 16px;
        margin-top: 20px;
        transition: background-color 0.3s, transform 0.2s;
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

        table {
            font-size: 14px;
        }

        button {
            width: 100%;
        }
    }

    /* ===== STYLES UNTUK CETAK STRUK ===== */
    @media print {
        body {
            background: #fff;
            color: #000;
            padding: 10px;
        }

        table {
            border: 1px solid #000;
            background: #fff;
            color: #000;
        }

        button {
            display: none;
        }
    }
</style>

    <a href="index.php">dashboard</a>
    <h2>Laporan Penjualan Bulanan</h2>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Bulan</th>
            <th>Total Penjualan</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($data)) : ?>
            <tr>
                <td><?= date('F Y', strtotime($row['bulan'] . '-01')) ?></td>
                <td>Rp<?= number_format($row['total_bulanan'], 2) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
    <button onclick="window.print()">Cetak laporan harian</button>
</body>
</html>
