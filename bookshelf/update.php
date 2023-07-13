<?php
require("connection.php");
require("global_vars.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $judul = $_POST["judul"];
    $author = $_POST["author"];
    $gambar = ""; // To store the new image file name
    $kategori = $_POST["kategori"];

    // Check if a new image file was uploaded
    if ($_FILES["gambar"]["name"] != "") {
        // Remove the existing image file
        $oldImage = $book["gambar"];
        if ($oldImage != "") {
            unlink($images_dir . $oldImage);
        }

        // Upload the new image file
        $temp = explode(".", basename($_FILES["gambar"]["name"]));
        $newfilename = date('dmYHis') . "." . $temp[count($temp) - 1];
        $target_file = $images_dir . $newfilename;
        move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);
        $gambar = $newfilename;
    } else {
        // Keep the existing image file
        $gambar = $book["gambar"];
    }

    // Update the book details in the database
    $sql = "UPDATE buku SET judul = '$judul', author = '$author', gambar = '$gambar', kategori = '$kategori' WHERE id = '$id'";
    if ($con->query($sql)) {
        // Redirect to admin.php if the update is successful
        header("Location: admin.php");
        exit;
    } else {
        echo "Error updating book: " . $con->error;
    }
} else {
    // Redirect to admin.php if the form was not submitted
    header("Location: admin.php");
    exit;
}
?>
