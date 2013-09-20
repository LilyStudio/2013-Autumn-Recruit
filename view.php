<?php session_start(); ?>
<html>
<head>
<script type="text/javascript" src="jquery-1.9.1.min.js"></script>
</head>
<body>
<h1> Welcome to Project LilyPRISM !</h1>
<table border="2">
<tr><th>Time</th><th>Name</th><th>Number</th><th>Dept</th><th>Phone</th><th>Cat</th><th>Experience</th><th>Hobby</th>
</tr>
<?php 
	$number = $_REQUEST['number'];
	$edit = $_REQUEST['edit'];
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
	if ($number && !$edit) {
			echo "<h2><a href='view.php?number=$number&edit=true'>添加信息</a></h2>";
			if ($files = scandir("$number")) {
					foreach( $files as $index=>$file_name ) {
						if ($index > 1) {
							$file = file_get_contents("$number/$file_name") or exit("Unable to open file $file_name!");
							echo "<h2>$file_name</h2>";
							echo "<p>$file</p>";
						}
					}
			} else {
					mkdir("$number");
			}
	} elseif ($number && $edit) {
			
?>
			<script>
			var name = window.prompt("Please enter your real name","Default");
			</script>
<form id='formId' action='addinfo.php' action='post'>
<p>Number:<textarea  id="number" name="number"><?php echo $number ?></textarea></p>
<p>Name:<textarea id="name" name="name"></textarea></p>
<p>Text:<textarea id="content" name="content"></textarea></p>
<p><input type="submit" id="submit" value="Submit"/></p>
</form>
<div id="msg"></div>
			<script>
			document.getElementById('name').value = name;
			</script>
<?php
	}
?>
</body>
	<script>
	$("#submit").click(function() {
		$.ajax({
			type:"POST",
			url: "addinfo.php",
			data: $("#formId").serialize(),
			success: function(data) {
				$("#msg").html('saved ' + data);
			}
		});
		return false;
	});
	</script>
</html>
