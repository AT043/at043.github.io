<?php
require("connection.php");
require("global_vars.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST["judul"];
    $author = $_POST["author"];
    $gambar = "";
    $filepdf = "";
    $kategori = $_POST["kategori"];

    if ($_FILES["gambar"]["name"] != "") {
        $temp = explode(".", basename($_FILES["gambar"]["name"]));
        $newfilename = date('dmYHis') . "." . $temp[count($temp) - 1];
        $target_file = $images_dir . $newfilename;
        move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);
        $gambar = $newfilename;
    }

    if ($_FILES["filepdf"]["name"] != "") {
        $pdf_temp = explode(".", basename($_FILES["filepdf"]["name"]));
        $pdf_newfilename = date('dmYHis') . "." . $pdf_temp[count($pdf_temp) - 1];
        $pdf_target_file = $pdf_dir . $pdf_newfilename;
        move_uploaded_file($_FILES["filepdf"]["tmp_name"], $pdf_target_file);
        $filepdf = $pdf_newfilename;
    }
    
    
    $sql = "INSERT INTO buku (judul, author, kategori, gambar, filepdf)
    VALUES ('{$judul}', '{$author}', '{$kategori}', '{$gambar}', '{$filepdf}')";
    if ($con->query($sql)) {
        echo "<script>window.alert('Berhasil menambahkan buku.');
            window.location.href='/';</script>";
    } else {
        echo "Gagal menambahkan buku: {$con->error}";
    }
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bookshelf | Tambah</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .form {
            background-color: azure;
            color: black;
            font-size: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            list-style: none;
        }

        h1 {
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 40px;
            margin-bottom: 10px;
        }
        
    </style>
</head>
<body>
    <h1>Tambah Buku</h1>
    <div class="form">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
        <label>Judul</label>
        <input type="text" name="judul" size="100" maxlength="200" required>
        <label>Author</label>
        <input type="text" name="author" size="100" maxlength="150">
        <label>Kategori</label>
        <select name="kategori" required>
        <?php
        foreach ($category as $key => $value) {
            echo "<option value='{$key}'>{$value}</option>";
        }
        ?>
        </select>
        <label>Gambar</label>
        <input type="file" name="gambar" accept="image/">

        <label>Ebook</label>
        <input type="file" name="pdf" accept="pdffile/">
        <button class="btn" type="submit">Tambah</button>
    </form>
    </div>
    
</body>
</html>
