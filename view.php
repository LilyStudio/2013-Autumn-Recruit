<?php 
	if(!isset($_SESSION)) {
			session_start();
	}
?>
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
	if (!isset($_SESSION['name']) && !isset($_REQUEST['name'])) {
		header("Location: login.html");
	} elseif (isset($_REQUEST['name'])) {
		$_SESSION['name'] = $_REQUEST['name'];
	}
	$number = $_REQUEST['number'];
	$edit = $_REQUEST['edit'];
	header("Content-Type:text/html;charset=UTF-8");
	$file = fopen("table.txt","r") or exit("Unable to open file!");
	while (($line = fgets($file)) != false ) {
		$arr_line = explode("\t",$line);
		if (!$number) {
			echo "<tr>";
			foreach($arr_line as $index=>$cell) {
				if ($index == 1) {
					echo "<td><a href='view.php?number=$arr_line[2]'>$cell</a></td>";
				}
				else {
					echo "<td>$cell</td>";
				}
			}
			echo "</tr>";
		} else {
			if ($arr_line[2] == $number) {
				echo "<tr>";
				foreach($arr_line as $cell) {
					echo "<td>$cell</td>";
				}
				echo "</tr>";
			}	
		
		}
	}
	fclose($file);
?>
</table>
<p>你现在登录为<?php echo $_SESSION['name']; ?>。<a href='login.html'>不是你？</a></p>
<p><a href="view.php">返回列表</a></p>
<?php 
	if ($number && !$edit) {
			echo "<h2><a href='view.php?number=$number&edit=true'>添加/修改你的记录</a></h2>";
			if ($files = scandir("./details/$number")) {
					foreach( $files as $index=>$file_name ) {
						if ($index > 1) {
							$file = str_replace("\n","<br />",file_get_contents("details/$number/$file_name"));
							echo "<h2>$file_name 的记录</h2>";
							echo "<p>$file</p>";
						}
					}
			} else {
					mkdir("./details/$number",0777,true);
			}
	} elseif ($number && $edit) {
			if (!isset($_SESSION['name'])) { 
					header("Location: login.html");
			}
?>
<form id='formId' action='addinfo.php' action='post'>
<p>学号:<input type="text" id="number" name="number" value="<?php echo $number; ?>" readonly></input></p>
<p>你的名字:<input type="text" id="name" name="name" value="<?php echo $_SESSION['name']; ?>" readonly></input></p>
<p>记录一下吧:<br /><textarea id="content" name="content" rows="18" cols="40"></textarea></p>
<p><input type="submit" id="submit" value="保存"/></p>
</form>
<div id="msg"></div>
			<script>
			$.ajax({
				type:"POST",
				url: "getfile.php",
				data: "number=<?php echo $number ?>&name=<?php echo $_SESSION['name']; ?>",
				success: function(data) {
					$("#content").html(data);
				}
			});
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
			data: $("#formId").serialize().replace(/%0D%0A/g,"<br />"),
			success: function(data) {
				$("#msg").show();
				$("#msg").html(data);
				$("#msg").delay(5000).fadeOut();
			}
		});
		return false;
	});
	</script>
</html>
