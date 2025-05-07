<?php
session_start();
include 'connection.php';


$id_user = 1; 


if (isset($_POST['tambah'])) {
    $id_produk = $_POST['id_produk'];
    $jumlah = $_POST['jumlah'];

    $produk = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk = '$id_produk'");
    $data = mysqli_fetch_assoc($produk);
    $subtotal = $data['harga'] * $jumlah;

    mysqli_query($koneksi, "INSERT INTO detail_penjualan (id_produk, id_user, jumlah_produk, subtotal, id_penjualan) VALUES ('$id_produk', '$id_user', '$jumlah', '$subtotal', NULL)");
    header("Location: transaksi.php");
    exit;
}


if (isset($_POST['update'])) {
    $id_detail = $_POST['id_detail'];
    $jumlah = $_POST['jumlah'];

    $query = mysqli_query($koneksi, "SELECT * FROM detail_penjualan JOIN produk ON detail_penjualan.id_produk = produk.id_produk WHERE id_detail = '$id_detail'");
    $row = mysqli_fetch_assoc($query);
    $subtotal = $row['harga'] * $jumlah;

    mysqli_query($koneksi, "UPDATE detail_penjualan SET jumlah_produk = '$jumlah', subtotal = '$subtotal' WHERE id_detail = '$id_detail'");
    header("Location: transaksi.php");
    exit;
}


if (isset($_GET['hapus'])) {
    $id_detail = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM detail_penjualan WHERE id_detail = '$id_detail'");
    header("Location: transaksi.php");
    exit;
}


$kembalian = null;
if (isset($_POST['simpan_transaksi'])) {
    $diskon = $_POST['diskon'];
    $bayar = $_POST['bayar'];

    $data = mysqli_query($koneksi, "SELECT * FROM detail_penjualan WHERE id_user = '$id_user' AND id_penjualan IS NULL");
    $total = 0;
    while ($row = mysqli_fetch_assoc($data)) {
        $total += $row['subtotal'];
    }

    $total_setelah_diskon = $total - $diskon;
    $kembalian = $bayar - $total_setelah_diskon;
    $tanggal = date('Y-m-d');

    
    mysqli_query($koneksi, "INSERT INTO penjualan (tanggal_penjualan, total_harga) VALUES ('$tanggal', '$total_setelah_diskon')");
    $id_penjualan = mysqli_insert_id($koneksi);

    
    mysqli_query($koneksi, "UPDATE detail_penjualan SET id_penjualan = '$id_penjualan' WHERE id_user = '$id_user' AND id_penjualan IS NULL");

    
    mysqli_query($koneksi, "INSERT INTO laporan_harian (total_penjualan, tanggal_penjualan, nama_kasir, id_user) VALUES ('$total_setelah_diskon', '$tanggal', 'Kasir', '$id_user')");

    
    $_SESSION['struk'] = [
        'id_penjualan' => $id_penjualan,
        'tanggal' => $tanggal,
        'total' => $total,
        'diskon' => $diskon,
        'total_setelah_diskon' => $total_setelah_diskon,
        'bayar' => $bayar,
        'kembalian' => $kembalian,
        'nama_kasir' => 'struk',
        'produk' => []
    ];

    
    $produk_transaksi = mysqli_query($koneksi, "SELECT dp.*, p.nama_produk, p.harga FROM detail_penjualan dp JOIN produk p ON dp.id_produk = p.id_produk WHERE dp.id_penjualan = '$id_penjualan'");
    while ($row = mysqli_fetch_assoc($produk_transaksi)) {
        $_SESSION['kasir']['produk'][] = $row;
    }

    
    header("Location: struk.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transaksi Penjualan</title>
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
        background: linear-gradient(135deg, #1e3c72, #2a5298); /* biru tua ke biru cerah */
        color: #ffffff;
        padding: 30px;
        min-height: 100vh;
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

    h2, h3 {
        margin-bottom: 20px;
        color: #ffffff;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
    }

    /* ===== FORM UMUM ===== */
    form {
        background: rgba(255, 255, 255, 0.1);
        padding: 25px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        transition: transform 0.2s ease;
    }

    form:hover {
        transform: translateY(-3px);
    }

    select, input[type="number"] {
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

    select {
        background-color: rgba(255, 255, 255, 0.2);
        color: #fff;
    }

    select:focus {
        outline: none;
        background-color: #ffe082; /* warna latar belakang saat fokus */
        color: #222; /* warna teks saat fokus */
    }

    select option {
        background-color: #1e3c72;
        color: #fff;
    }

    select:focus option {
        background-color: #ffe082;
        color: #222;
    }

    input[type="number"]:focus {
        outline: none;
        background-color: rgba(255,255,255,0.3);
    }

    button {
        padding: 12px 18px;
        background-color: #ffe082;
        color: #222;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        font-size: 15px;
        margin-top: 10px;
        transition: background-color 0.3s, transform 0.2s;
    }

    button:hover {
        background-color: #ffca28;
        transform: scale(1.05);
    }

    /* ===== TABEL KERANJANG ===== */
    table {
        width: 100%;
        border-collapse: collapse;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        margin-bottom: 30px;
    }

    th, td {
        padding: 14px 16px;
        text-align: left;
        border-bottom: 1px solid rgba(255,255,255,0.2);
    }

    th {
        background-color: rgba(0, 0, 0, 0.3);
        color: #ffeb3b;
        font-size: 16px;
    }

    td {
        color: #ffffff;
        font-size: 15px;
    }

    tr:hover {
        background: rgba(255, 255, 255, 0.05);
    }

    /* ===== STRONG DAN TOTAL ===== */
    strong {
        color: #ffffff;
        font-size: 18px;
    }

    /* ===== MEDIA QUERY RESPONSIVE ===== */
    @media (max-width: 768px) {
        body {
            padding: 15px;
        }

        form, table {
            font-size: 14px;
        }

        select, input[type="number"] {
            width: 100%;
        }

        button {
            width: 100%;
        }
    }

    /* ===== ANIMASI MASUK ===== */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    form, table {
        animation: fadeIn 0.6s ease-in-out;
    }
</style>

    </style>
<h2>Transaksi Penjualan</h2>
<a href="index.php"><-Dashboard</a>


<form method="POST">
    <select name="id_produk" required>
        <option value="">-- Pilih Produk --</option>
        <?php
        $produk = mysqli_query($koneksi, "SELECT * FROM produk");
        while ($row = mysqli_fetch_assoc($produk)) {
            echo "<option value='{$row['id_produk']}'>{$row['nama_produk']} - Rp{$row['harga']}</option>";
        }
        ?>
    </select>
    Jumlah: <input type="number" name="jumlah" required min="1">
    <button type="submit" name="tambah">Tambah</button>
</form>


<h3>Keranjang</h3>
<table border="1" cellpadding="8">
    <tr>
        <th>Produk</th>
        <th>Harga</th>
        <th>Jumlah</th>
        <th>Subtotal</th>
        <th>Hapus</th>
        
    </tr>
    <?php
    $keranjang = mysqli_query($koneksi, "SELECT d.*, p.nama_produk, p.harga FROM detail_penjualan d JOIN produk p ON d.id_produk = p.id_produk WHERE d.id_user = '$id_user' AND d.id_penjualan IS NULL");
    $total = 0;
    while ($row = mysqli_fetch_assoc($keranjang)) {
        echo "
        <tr>
            <td>{$row['nama_produk']}</td>
            <td>Rp{$row['harga']}</td>
            <td>
                <form method='POST' style='display:inline;'>
                    <input type='hidden' name='id_detail' value='{$row['id_detail']}'>
                    <input type='number' name='jumlah' value='{$row['jumlah_produk']}' min='1'>
                    <button type='submit' name='update'>Update</button>
                </form>
            </td>
            <td>Rp{$row['subtotal']}</td>
            <td><a href='transaksi.php?hapus={$row['id_detail']}'>Hapus</a></td>
        </tr>";
        $total += $row['subtotal'];
    }
    ?>
    <tr>
        <td colspan="3"><strong>Total</strong></td>
        <td colspan="3"><strong>Rp<?= $total; ?></strong></td>
    </tr>
</table>


<h3>Finalisasi Transaksi</h3>
<form method="POST">
    Diskon: <input type="number" name="diskon" value="0" min="0"><br>
    Bayar: <input type="number" name="bayar" required min="0"><br>
    <button type="submit" name="simpan_transaksi">Simpan Transaksi</button>
</form>

</body>
</html>
