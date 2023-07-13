<?php
// menyertakan file program koneksi.php pada register
require('connection.php');
// inisialisasi session
session_start();
$error = '';
$validate = '';
// mengecek apakah form registrasi di submit atau tidak
if (isset($_POST['register'])) {
    // menghilangkan backslashes
    $username = stripslashes($_POST['newUsername']);
    // cara sederhana mengamankan dari sql injection
    $username = mysqli_real_escape_string($con, $username);
    $password = stripslashes($_POST['newPassword']);
    $password = mysqli_real_escape_string($con, $password);
    $repass = stripslashes($_POST['repassword']);
    $repass = mysqli_real_escape_string($con, $repass);
    // cek apakah nilai yang diinputkan pada form ada yang kosong atau tidak
    if (!empty(trim($username)) && !empty(trim($password)) && !empty(trim($repass))) {
        // mengecek apakah password yang diinputkan sama dengan re-password yang diinputkan kembali
        if ($password == $repass) {
            // memanggil method cek_nama untuk mengecek apakah user sudah terdaftar atau belum
            if (cek_nama($username, $con) == 0) {
                // hashing password sebelum disimpan didatabase
                $pass = password_hash($password, PASSWORD_DEFAULT);
                // insert data ke database
                $query = "INSERT INTO masuk (username, password) VALUES ('$username', '$pass')";
                $result = mysqli_query($con, $query);
                // jika insert data berhasil maka akan diredirect ke halaman index.php serta menyimpan data username ke session
                if ($result) {
                    $_SESSION['username'] = $username;
                    header('Location: index.php');
                    exit;
                } else {
                    $error = 'Register User Gagal !!';
                }
            } else {
                $error = 'Username sudah terdaftar !!';
            }
        } else {
            $validate = 'Password tidak sama !!';
        }
    } else {
        $error = 'Data tidak boleh kosong !!';
    }
}
// fungsi untuk mengecek username apakah sudah terdaftar atau belum
function cek_nama($username, $con)
{
    $nama = mysqli_real_escape_string($con, $username);
    $query = "SELECT * FROM masuk WHERE username = '$nama'";
    if ($result = mysqli_query($con, $query)) {
        return mysqli_num_rows($result);
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="style.css">

    <style>
        body {
            background-color: azure;
            color: black;
            font-size: 20px;
        }

        ul,
        h1 {
            margin: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        li {
            list-style: none;
            margin: 0.5rem;
        }

        p {
            color: red;
        }
    </style>
</head>

<body>

    <h1>Add User</h1>

    <?php if (!empty($error)) : ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>

    <ul>
        <form method="post">
            <li>
                <label for="newUsername">Username</label>
                <input type="text" name="newUsername" id="newUsername" placeholder="New Username">
            </li>
            <li>
                <label for="newPassword">Password</label>
                <input type="password" name="newPassword" id="newPassword" placeholder="New Password">
            </li>
            <li>
                <label for="repassword">Re-enter Password</label>
                <input type="password" name="repassword" id="repassword" placeholder="Re-enter Password">
            </li>
            <li>
                <button type="submit" name="register">Add User</button>
            </li>
        </form>
    </ul>
</body>

</html>
