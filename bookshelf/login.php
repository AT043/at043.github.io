<?php
// menyertakan file program koneksi.php pada register
require('connection.php');
// inisialisasi session
session_start();
$error = 'User/Password Salah!';
$validate = '';
// mengecek apakah session username tersedia atau tidak jika tersedia maka akan diredirect ke halaman index
if (isset($_SESSION['username'])) {
    header('Location: admin.php');
    exit;
}
// mengecek apakah form disubmit atau tidak
if (isset($_POST['submit'])) {

    // menghilangkan backslashes
    $username = stripslashes($_POST['username']);
    // cara sederhana mengamankan dari sql injection
    $username = mysqli_real_escape_string($con, $username);
    // menghilangkan backslashes
    $password = stripslashes($_POST['password']);
    // cara sederhana mengamankan dari sql injection
    $password = mysqli_real_escape_string($con, $password);

    // cek apakah nilai yang diinputkan pada form ada yang kosong atau tidak
    if (!empty(trim($username)) && !empty(trim($password))) {
        // select data berdasarkan username dari database
        $query  = "SELECT * FROM masuk WHERE username = '$username'";
        $result = mysqli_query($con, $query);
        $rows   = mysqli_num_rows($result);
        if ($rows != 0) {
            $hash = mysqli_fetch_assoc($result)['password'];
            if (password_verify($password, $hash)) {
                $_SESSION['username'] = $username;
                header('Location: admin.php');
                exit;
            }
        // jika gagal maka akan menampilkan pesan error
        } else {
            $error = 'Login gagal! Silakan cek username dan password Anda.';
        }
    } else {
        $error = 'Data tidak boleh kosong!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: azure;
            color: black;
            font-size: 20px;
        }

        ul,
        p,
        h1 {
            margin: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        li {
            list-style: none;
            margin: 1rem;
        }
    </style>
</head>

<body>

    <h1>Login</h1>
    <?php if (!empty($error)) : ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <ul>
        <form method="post">
            <li>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="user">
            </li>
            <li>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="password">
            </li>
            <li>
                <button type="submit" name="submit">Login</button>
            </li>
        </form>
        <li>
            <a class="btn" href="add_user.php">Add New User</a>
        </li>
    </ul>
</body>

</html>
