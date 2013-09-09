<html>
<head></head>
<body>
<h1> Hack Page </h1>
<table border="2">
<tr><th>Name</th><th>Number</th><th>Dept</th><th>Phone</th><th>Cat</th>
</tr>
<?php
	header("Content-Type:text/html;charset=UTF-8");
	$file = fopen("hack.txt","r") or exit("Unable to open file!");
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
