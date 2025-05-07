<?php
include 'connection.php';

if (isset($_POST["submit"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $perintah= "SELECT * FROM akun WHERE username = '$username' AND password = '$password'"; 
    $kirim= mysqli_query($koneksi,$perintah);
    $minta= mysqli_fetch_assoc($kirim);
    if (mysqli_num_rows($kirim) == 1) {
        header("location:index.php");
    }
    
    }




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <style>
        /* Global Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    height: 100vh;
    background: linear-gradient(135deg, #141e30, #243b55);
    font-family: 'Poppins', sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
}

/* Form container */
form {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    padding: 40px 35px;
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.35);
    width: 100%;
    max-width: 400px;
    animation: fadeIn 1s ease-in-out;
}

/* Animasi fade in */
@keyframes fadeIn {
    0% {
        opacity: 0;
        transform: translateY(30px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Label styling */
label {
    display: block;
    font-size: 15px;
    margin-bottom: 6px;
    font-weight: 500;
}

/* Input styling */
input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 12px 15px;
    margin-bottom: 20px;
    border: none;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
    font-size: 15px;
    transition: background 0.3s, transform 0.2s;
}

input:focus {
    background: rgba(255, 255, 255, 0.15);
    outline: none;
    transform: scale(1.02);
}

/* Tombol submit */
button {
    width: 100%;
    padding: 12px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
    border-radius: 10px;
    color: #fff;
    font-weight: bold;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.4s ease, transform 0.2s;
}

button:hover {
    background: linear-gradient(135deg, #5a67d8, #6b46c1);
    transform: translateY(-2px);
}

button:active {
    transform: translateY(1px);
}

    </style>
    <form method="POST">
    <label for="username">username:</label><br>
  <input type="text" id="username" name="username"><br>
  <label for="password">password:</label><br>
  <input type="password" id="pwd" name="password">
  <button name="submit">submit</button>
    </form>
</body>
</html>