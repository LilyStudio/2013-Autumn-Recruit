<html>
<head></head>
<body>
<h1> View Page </h1>
<table border="2">
<tr><th>Time</th><th>Name</th><th>Number</th><th>Dept</th><th>Phone</th><th>Cat</th><th>Experience</th><th>Hobby</th>
</tr>
<?php 
	$number = $_REQUEST['number'];
	header("Content-Type:text/html;charset=UTF-8");
	$file = fopen("table.txt","r") or exit("Unable to open file!");
	while (($line = fgets($file)) !== false ) {
		$arr_line = explode("\t",$line);
		echo "<tr>";
		if (!$number) {
			foreach($arr_line as $index=>$cell) {
				if ($index == 1) {
					echo "<td><a href='view.php?number=$arr_line[2]'>$cell</a></td>";
				}
				else {
					echo "<td>$cell</td>";
				}
			}
		} else {
			foreach($arr_line as $cell) {
				if ($arr_line[2] == $number) {
					echo "<td>$cell</td>";
				}
			}	
		
		}
		echo "</tr>";
	}
	fclose($file);
?>
</table>
<?php 
	if ($number) {
			if ($files = scandir('$number')) {
					foreach( $files as $file_name ) {
						$file = fopen( $file_name, "r") or exit("Unable to open file $file_name!");
						echo "<h2>$file_name</h2>";
						while (($line = fgets($file)) !== false) {
							echo "<p>$line</p>";
						}
						fclose($file);
					}
			} else {
					mkdir('$number');
			}
	}
?>
</body>
</html>
