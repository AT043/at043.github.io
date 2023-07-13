<?php
require("connection.php");
require("global_vars.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookshelf</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
        <ul class="nav-menu">
            <a href="#" class="nav-logo">AT043.</a>
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link">home</a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link">logout</a>
                    </li>
                    <li class="nav-item">
                        <a href="addbuku.php" class="btn-green">Tambah Buku</a>
                    </li>
                </ul>
                <div class="hamburger">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
        </nav>
        <jumbotron>
            <div class="typing-effect">
                <p>Baca Buku...!</p>
            </div>
        </jumbotron>
    </header>
    <main>
    <?php
    $sql = "SELECT DISTINCT kategori FROM buku";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $kategori = $row['kategori'];
    ?>
    <div class="book-item">
        <table>
            <tr>
                <th colspan="4"><?php echo strtoupper($kategori); ?></th>
            </tr>
            <tr>
                <th>Buku</th>
                <th>Author</th>
                <th>Update</th>
            </tr>
            <?php
            $bookSql = "SELECT * FROM buku WHERE kategori = '$kategori' ORDER BY diupdate";
            $bookResult = $con->query($bookSql);
            if ($bookResult->num_rows > 0) {
                while ($bookRow = $bookResult->fetch_assoc()) {
            ?>
            <tr>
                <td><a href="show.php?id=<?php echo $bookRow['id']; ?>"><img src="/images/<?php echo $bookRow['gambar']; ?>" height="200"></a><p><?php echo $bookRow["judul"]; ?></p><a class="btn-green" href="#">Baca</a></td>
                <td><span><?php echo $bookRow["author"]; ?></span></td>
                <td><span><?php echo $bookRow["diupdate"]; ?></span></td>
                <td><a class="btn" href="edit.php">edit</a></br><a class="btn-red" href="#">hapus</a></td>
            </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='3'>Belum ada buku dalam kategori ini.</td></tr>";
            }
            ?>
        </table>
    </div>
    <?php } ?>
    <?php
    } else {
        echo "<table><tr><td>Belum ada buku.</td></tr></table>";
    }
    ?>
    </main>
    <footer>
        <p>AT043.</p>
    </footer>
</body>
</html>