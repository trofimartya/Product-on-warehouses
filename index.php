<?php
	// Декодируем файл сохранения данных
	$file = 'info.json';
	$decode = json_decode(file_get_contents($file));

if (isset($_POST['Submit'])) {
	print_r($_FILES);
}
?>

	<!-- Шапка сайта -->
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Product quantity</title>
	<!-- CSS форма таблицы -->
	<link rel="stylesheet" href="external.css">
</head>
<body>
	<h1 align="center">Product quantity</h1>
		<!-- В форму загружаем файл со скриптом-->	
		<form align="center" action="load.php"  method="post" enctype="multipart/form-data">
		Upload file
		<input type="file" name="csv" value="" id="csv_file" accept=".csv"/>
		<input type="submit" value="Submit" name="submit" id="upload"/>
		</form>
	<hr>
	<table align="center" border="3">
		<thead>
			<th>Product name</th>
			<th>Quantity</th>
			<th>Warehouses</tH>
		</thead>
		<tbody>
			<!-- Отображение результатов с помощью цикла foreach -->
		<?php foreach ($decode as $value): ?>
		<tr>
			<td><?= $value[0] ?></td>
			<td><?= $value[1] ?></td>
			<td><?= $value[2] ?></td>
		</tr>
	<?php endforeach; ?>

	</tbody>
	</table>
		
</body>
</html>