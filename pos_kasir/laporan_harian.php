<?php
include 'connection.php';


$id_user = 1;


if (isset($_POST['simpan'])) {
    $total_penjualan = $_POST['total_penjualan'];
    $tanggal_penjualan = date('Y-m-d');

    $query = "INSERT INTO laporan_harian (total_penjualan, tanggal_penjualan, id_user)
              VALUES ('$total_penjualan', '$tanggal_penjualan', '$id_user')";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Laporan berhasil disimpan!'); window.location='laporan_harian.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan laporan');</script>";
    }
}


if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM laporan_harian WHERE id_laporan_harian='$id'");
    header("Location: laporan_harian.php");
}


$data = mysqli_query($koneksi, "
    SELECT lh.*, a.username 
    FROM laporan_harian lh
    JOIN akun a ON lh.id_user = a.id_user
    ORDER BY lh.tanggal_penjualan DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Harian</title>
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
        font-family: 'Arial', sans-serif;
        background: linear-gradient(135deg, #6a1b9a, #3f51b5); /* Gradasi ungu ke biru */
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
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
    }

    h3 {
        margin-top: 30px;
        font-size: 20px;
        color: #ffeb3b;
    }

    /* ===== FORM INPUT ===== */
    form {
        background: rgba(255, 255, 255, 0.1);
        padding: 25px;
        border-radius: 10px;
        margin-bottom: 30px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    input[type="number"] {
        width: 250px;
        padding: 12px;
        margin: 10px 0;
        border-radius: 8px;
        border: none;
        background: rgba(255,255,255,0.2);
        color: #fff;
        font-size: 16px;
        transition: background 0.3s ease;
    }

    input[type="number"]:focus {
        outline: none;
        background: rgba(255,255,255,0.3);
    }

    button {
        padding: 12px 18px;
        background-color: #ffeb3b;
        color: #222;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        font-size: 16px;
        margin-top: 10px;
        transition: background-color 0.3s, transform 0.2s;
    }

    button:hover {
        background-color: #ffe082;
        transform: scale(1.05);
    }

    /* ===== TABEL DAFTAR LAPORAN ===== */
    table {
        width: 100%;
        border-collapse: collapse;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        margin-top: 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
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

    td a {
        color: #ffeb3b;
        text-decoration: none;
        font-weight: bold;
    }

    td a:hover {
        color: #fff176;
    }

    /* ===== MEDIA QUERY RESPONSIVE ===== */
    @media (max-width: 768px) {
        body {
            padding: 15px;
        }

        form, table {
            font-size: 14px;
        }

        input[type="number"] {
            width: 100%;
        }

        button {
            width: 100%;
        }
    }
</style>

    </style>
    <a href="index.php">kembali dashboard</a>
    <h2>Input Laporan Harian</h2>
    <form method="POST">
        Total Penjualan: <input type="number" step="0.01" name="total_penjualan" required>
        <button type="submit" name="simpan">Simpan</button>
    </form>

    <h3>Daftar Laporan Harian</h3>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Tanggal</th>
            <th>Total</th>
            <th>Nama Kasir</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($data)) : ?>
            <tr>
                <td><?= $row['tanggal_penjualan'] ?></td>
                <td>Rp<?= number_format($row['total_penjualan'], 2) ?></td>
                <td><?= $row['username'] ?></td>
                <td><a href="laporan_harian.php?hapus=<?= $row['id_laporan_harian'] ?>">Hapus</a></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
