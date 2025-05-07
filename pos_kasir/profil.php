<?php
include 'connection.php';

// Tambah Akun
if (isset($_POST['tambah'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $level = $_POST['level'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $alamat = $_POST['alamat'];

    $query = "INSERT INTO akun (username, password, level, email, no_hp, tgl_lahir, alamat)
              VALUES ('$username', '$password', '$level', '$email', '$no_hp', '$tgl_lahir', '$alamat')";
    mysqli_query($koneksi, $query);
    header("Location: profil.php");
}

// Hapus Akun
if (isset($_GET['hapus'])) {
    $id_user = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM akun WHERE id_user='$id_user'");
    header("Location: profil.php");
}

// Edit Akun
$edit = null;
if (isset($_GET['edit'])) {
    $id_user = $_GET['edit'];
    $result = mysqli_query($koneksi, "SELECT * FROM akun WHERE id_user='$id_user'");
    $edit = mysqli_fetch_assoc($result);
}

// Update Akun
if (isset($_POST['update'])) {
    $id_user = $_POST['id_user'];
    $username = $_POST['username'];
    $level = $_POST['level'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $alamat = $_POST['alamat'];

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $query = "UPDATE akun SET username='$username', password='$password', level='$level', email='$email', no_hp='$no_hp', tgl_lahir='$tgl_lahir', alamat='$alamat' WHERE id_user='$id_user'";
    } else {
        $query = "UPDATE akun SET username='$username', level='$level', email='$email', no_hp='$no_hp', tgl_lahir='$tgl_lahir', alamat='$alamat' WHERE id_user='$id_user'";
    }

    mysqli_query($koneksi, $query);
    header("Location: profil.php");
}

// Ambil semua data akun
$data = mysqli_query($koneksi, "SELECT * FROM akun");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Akun</title>
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
        background: linear-gradient(135deg, #6a11cb, #2575fc); /* Gradasi ungu ke biru */
        color: #fff;
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
        color: #ffeb3b;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #ffeb3b;
        font-size: 24px;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    }

    /* ===== FORM AKUN ===== */
    form {
        background: rgba(255, 255, 255, 0.1);
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        transition: transform 0.2s ease;
    }

    form:hover {
        transform: translateY(-3px);
    }

    input[type="text"],
    input[type="number"],
    input[type="email"],
    input[type="date"],
    textarea,
    select {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border-radius: 8px;
        border: none;
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        font-size: 16px;
        transition: background 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="number"]:focus,
    input[type="email"]:focus,
    input[type="date"]:focus,
    select:focus,
    textarea:focus {
        outline: none;
        background: rgba(255, 255, 255, 0.3);
    }

    button {
        padding: 12px 18px;
        background-color: #ffe082;
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
        background-color: #ffca28;
        transform: scale(1.05);
    }

    /* ===== TABEL AKUN ===== */
    table {
        width: 100%;
        border-collapse: collapse;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    th, td {
        padding: 14px 16px;
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

    /* ===== MEDIA QUERY RESPONSIVE ===== */
    @media (max-width: 768px) {
        body {
            padding: 15px;
        }

        form, table {
            font-size: 14px;
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

    <h2><?= isset($edit) ? 'Edit' : 'Tambah' ?> Akun</h2>
    <form method="POST">
        <input type="hidden" name="id_user" value="<?= isset($edit) ? $edit['id_user'] : '' ?>">
        Username: <input type="text" name="username" required value="<?= isset($edit) ? $edit['username'] : '' ?>"><br>
        Password: <input type="number" name="password" <?= isset($edit) ? '' : 'required' ?>><br>
        Level: 
        <select name="level">
            <option value="admin" <?= isset($edit) && $edit['level'] == 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="user" <?= isset($edit) && $edit['level'] == 'user' ? 'selected' : '' ?>>User</option>
        </select><br>
        Email: <input type="email" name="email" value="<?= isset($edit) ? $edit['email'] : '' ?>"><br>
        No HP: <input type="number" name="no_hp" value="<?= isset($edit) ? $edit['no_hp'] : '' ?>"><br>
        Tanggal Lahir: <input type="date" name="tgl_lahir" value="<?= isset($edit) ? $edit['tgl_lahir'] : '' ?>"><br>
        Alamat: <textarea name="alamat"><?= isset($edit) ? $edit['alamat'] : '' ?></textarea><br>

        <button type="submit" name="<?= isset($edit) ? 'update' : 'tambah' ?>">
            <?= isset($edit) ? 'Update' : 'Tambah' ?>
        </button>
    </form>

    <h2>Daftar Akun</h2>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Level</th>
            <th>Email</th>
            <th>No HP</th>
            <th>Tgl Lahir</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($data)) : ?>
            <tr>
                <td><?= $row['id_user'] ?></td>
                <td><?= $row['username'] ?></td>
                <td><?= $row['level'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['no_hp'] ?></td>
                <td><?= $row['tgl_lahir'] ?></td>
                <td><?= $row['alamat'] ?></td>
                <td>
                    <a href="profil.php?edit=<?= $row['id_user'] ?>">Edit</a>
                    <a href="profil.php?hapus=<?= $row['id_user'] ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
