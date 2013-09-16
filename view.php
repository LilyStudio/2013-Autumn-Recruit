<html>
<head></head>
<body>
<h1> View Page </h1>
<table border="2">
<tr><th>Time</th><th>Name</th><th>Number</th><th>Dept</th><th>Phone</th><th>Cat</th><th>Experience</th><th>Hobby</th>
</tr>
<?php 
	header("Content-Type:text/html;charset=UTF-8");
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
