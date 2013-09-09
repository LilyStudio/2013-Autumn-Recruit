<html>
<head></head>
<body>
<table border="2">
<tr><td>Name</td><td>Number</td><td>Dept</td><td>Phone</td><td>Cat</td>
</tr>
<?php 
	$file = fopen("table.txt","r") or exit("Unable to open file!");
	while (($line = fgets($file)) !== false ) {
		$arr_line = explode("\t",$line);
		echo "<tr>";
		foreach($arr_line as $cell) {
			echo "<td>$cell</td>";
		}
		echo "</tr>";
	}
?>
</table>
</body>
</html>
