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

    if ($_FILES["pdf"]["name"] != "") {
        $pdf_temp = explode(".", basename($_FILES["pdf"]["name"]));
        $pdf_newfilename = date('dmYHis') . "." . $pdf_temp[count($pdf_temp) - 1];
        $pdf_target_file = $pdf_dir . $pdf_newfilename;
        move_uploaded_file($_FILES["pdf"]["tmp_name"], $pdf_target_file);
        $filepdf = $pdf_newfilename;
    }
    
    
    $sql = "INSERT INTO buku (judul, author, kategori, gambar, filepdf)
    VALUES ('{$judul}', '{$author}', '{$kategori}', '{$gambar}', '{$filepdf}')";
    if ($con->query($sql)) {
        echo "<script>window.alert('Berhasil menambahkan buku.');
            window.location.href='/';</script>";
    } else {
        echo "Gagal menambahkan buku: {$mysqli->error}";
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
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            max-width: 500px;
            width: 100%;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        h1 {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input, select {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Tambah Buku</h1>
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
        <input type="file" name="gambar" accept="image/*">

        <label>Ebook</label>
        <input type="file" name="pdf" accept="pdffile/*">
        <button class="btn" type="submit">Tambah</button>
    </form>
</body>
</html>
