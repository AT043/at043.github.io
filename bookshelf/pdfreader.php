<?php
require("connection.php");
require("global_vars.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Reader</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        embed {
            width: 100%;
            height: 100%;
        }

        .pdfobject-container { height: 500px;}
        .pdfobject { border: 1px solid #666; }
    </style>
    <script src="pdfobject.min.js"></script>
</head>
<body>
    <?php
    if (isset($_GET["id"])) {
        $id = $_GET["id"];

        $sql = "SELECT filepdf FROM buku WHERE id = '$id'";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            $pdfFile = $result->fetch_assoc()["filepdf"];
            $pdfPath = $pdf_dir . $pdfFile;
            if (file_exists($pdfPath)) {
    
                echo "<embed src='{$pdfPath}' type='application/pdf' />";

            } else {
                echo "PDF file not found.";
            }
        } else {
            echo "Invalid book ID.";
        }
    } else {
        echo "Book ID not provided.";
    }
    ?>
</body>
</html>

