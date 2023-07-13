<?php
require("connection.php");
require("global_vars.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    // Delete the book from the database
    $sql = "DELETE FROM buku WHERE id = '$id'";
    if ($con->query($sql)) {
        // Redirect to admin.php after successful deletion
        header("Location: admin.php");
        exit;
    } else {
        echo "Failed to delete the book: " . $con->error;
    }
} else {
    // Redirect to admin.php if the id is not provided
    echo "id not provided";
    header("Location: admin.php");
    exit;
}
?>
