<?php 
	
	if(isset($_POST['submit'])){
		$txt = $_POST['notes'];
		$notes = fopen('text.txt', 'w') or die('Terjadi Kesalahan, file tidak terdeteksi');

		fwrite($notes, $txt);
		fclose($notes);
	} 

	if (isset($_POST['reset'])) {
		// $txt = " ";
		// $notes = fopen('text.txt', 'w') or die('Terjadi Kesalahan, file tidak terdeteksi');

		// ftruncate($notes, 0);
		// fclose($notes);

		file_put_contents('text.txt', 'Write Here');
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Temporary Note</title>
	<style type="text/css">
		
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
			scroll-behavior: smooth;
		}

		html,
		body {
			height: 100%;
			width: 100%;
			font-family: monospace;
			font-size: 20px;
			background-color: #ffff;
			color: #000d;
		}

		header {
			padding: 30px;
		}

		header h2 {
			padding-bottom: 20px;
		}

		.outter-box{
			display: flex;
			justify-content: center;
			align-items: center;

		}

		.main-box {
			border: 1px solid black;
			height: 400px;
			width: 500px;
			background-color: #000d;
		}

		textarea {
			padding: 5px;
		}

	</style>
</head>
<body>
	<header>
		<h2>TEMPORARY NOTE 1.0</h2>
		<hr>
	</header>
	<main>
		<div class="outter-box">
			<div class="main-box">
				<form method="post">
				<div class="child-box">
				<?php 
					$notes = fopen('text.txt', 'r') or die ('Terjadi kesalahan, file tidak terbaca');
				?>
					<textarea name="notes" id="notes" cols="45" rows="15" maxlength="150"><?php echo fread($notes, filesize('text.txt')); ?></textarea>
				<?php fclose($notes); ?>
				</div>
				<input type="submit" name="submit">
				<input type="submit" name="reset" value="Delete">
				</form>
			</div>
		</div>		
	</main>
	<footer>
		<hr>
		<p>at043</p>
	</footer>
</body>
</html>