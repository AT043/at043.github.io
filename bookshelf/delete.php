<?php
require("connection.php");
require("global_vars.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "DELETE FROM buku WHERE id = '$id'";
    if ($con->query($sql)) {
        header("Location: admin.php");
        exit;
    } else {
        echo "Failed to delete the book: " . $con->error;
    }
} else {
    echo "id not provided";
    header("Location: admin.php");
    exit;
}
?>
