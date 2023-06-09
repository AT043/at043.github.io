<?php
require("connection.php");
require("global_vars.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    // Retrieve the book details from the database
    $sql = "SELECT * FROM buku WHERE id = '$id'";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        // Redirect to admin.php if the book is not found
        header("Location: admin.php");
        exit;
    }
} else {
    // Redirect to admin.php if the id is not provided
    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: azure;
            color: black;
            font-size: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            list-style: none;
        }

        h1 {
            font-size: 40px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <main>
        <div class="book-item">
            <h1>Edit Book</h1>
            <form method="post" action="update.php" method="post" action="update.php" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
                <label>Judul</label>
                <input type="text" name="judul" value="<?php echo $book['judul']; ?>" required>
                <label>Author</label>
                <input type="text" name="author" value="<?php echo $book['author']; ?>">
                <label>Gambar</label>
                <input type="file" name="gambar" accept="image/*">
                <label>Ebook</label>
                <input type="file" name="pdf" accept="application/pdf">
                <label>Kategori</label>
                <select name="kategori">
                    <?php
                    foreach ($category as $key => $value) {
                        $selected = ($book['kategori'] == $key) ? "selected" : "";
                        echo "<option value='{$key}' {$selected}>{$value}</option>";
                    }
                    ?>
                </select>

                <button class="btn" type="submit">Update</button>
            </form>
        </div>
    </main>
</body>
</html>
