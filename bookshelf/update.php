<?php
require("connection.php");
require("global_vars.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $judul = $_POST["judul"];
    $author = $_POST["author"];
    $gambar = ""; 
    $filepdf = "";
    $kategori = $_POST["kategori"];

    if ($_FILES["gambar"]["name"] != "") {

        $oldImage = $book["gambar"];
        if ($oldImage != "") {
            unlink($images_dir . $oldImage);
        }

        $temp = explode(".", basename($_FILES["gambar"]["name"]));
        $newfilename = date('dmYHis') . "." . $temp[count($temp) - 1];
        $target_file = $images_dir . $newfilename;
        move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);
        $gambar = $newfilename;
    } else {

        $gambar = $book["gambar"];
    }

    if ($_FILES["pdf"]["name"] != "") {

        $oldPdf = $book["pdf"];
        if ($oldPdf != "") {
            unlink($pdf_dir . $oldPdf);
        }

        $pdf_temp = explode(".", basename($_FILES["pdf"]["name"]));
        $pdf_newfilename = date('dmYHis') . "." . $pdf_temp[count($pdf_temp) - 1];
        $pdf_target_file = $pdf_dir . $pdf_newfilename;
        move_uploaded_file($_FILES["pdf"]["tmp_name"], $pdf_target_file);
        $filepdf = $pdf_newfilename;
    }else {

        $filepdf = $book["pdf"];
    }

    $sql = "UPDATE buku SET judul = '$judul', author = '$author', gambar = '$gambar', kategori = '$kategori', filepdf = '$filepdf' WHERE id = '$id'";
    if ($con->query($sql)) {
 
        header("Location: admin.php");
        exit;
    } else {
        echo "Error updating book: " . $con->error;
    }
} else {
    header("Location: admin.php");
    exit;
}
?>
