<?php 
	if(!isset($_SESSION)) {
			session_start();
	}
	header("Content-Type:text/html;charset=UTF-8");
	if (isset($_SESSION['name']) && !isset($_REQUEST['password'])) {
		
	} elseif (isset($_REQUEST['name']) && $_REQUEST['password']=="aaaaaaaa") {
		$_SESSION['name'] = $_REQUEST['name'];
	} elseif (isset($_SESSION['name']) && $_REQUEST['password']=="aaaaaaaa") {
	
	} else {
		header("Location: login.html");
	}
?>
<!DOCTYPE html>
<html>
<head>
		<script type="text/javascript" src="jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="./jquery.tablesorter.min.js"></script>
		<script type="text/javascript" src="./jquery-ui.js"></script>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="./tablesorter.css" rel="stylesheet">
		<link href="./jquery-ui.css" rel="stylesheet">
		<style>
			th {
				white-space:pre;
				padding-right:30px !important;
				font-size:14px !important;
			}
			table {
				font-size:14px !important;
			}
			.alert {
				display:none;
			}
		</style>
</head>
<body>
		<!-- container begin -->
		<div class="container">
				<div class="row">
						<div class="span8 offset2">
								<h1> Welcome to Project LilyPRISM !</h1>
						</div>
				</div>
				<div class="alert">
						<span class="alert-heading"><strong>Notice:</strong></span>
						想要添加照片，请先以<a href="login.html">photo账号登陆</a>，之后在记录中添加图片地址（需要添加"http://"），每张照片一行，不需要任何标签，照片会显示在所有记录的前面
				</div>
				<div class="alert alert-info">你现在登录为<strong><?php echo $_SESSION['name']; ?></strong>。<a href='login.html'>不是你？</a>
				</div>
				<table border="2" class="table table-striped tablesorter">
				<thead>
						<tr>
								<th>提交时间</th>
								<th>姓名</th>
								<th>学号</th>
								<th>院系</th>
								<th>联系方式</th>
								<th>组别</th>
								<th>平时经历</th>
								<th>个人爱好</th>
								<th>评论数</th>
						</tr>
				</thead>
				<tbody>
<?php
	
	$number = $_REQUEST['number'];
	$edit = $_REQUEST['edit'];
	$file = fopen("table.txt","r") or exit("Unable to open file!");
	while (($line = fgets($file)) != false ) {
		$arr_line = explode("\t",$line);
		if (!$number) {
			echo "<tr>";
			foreach($arr_line as $index=>$cell) {
				if ($index == 1) {
					echo "<td><a href='view1.php?number=$arr_line[2]'>$cell</a></td>";
				}
				else {
					echo "<td>$cell</td>";
				}
			}
			$files = scandir("./details/$arr_line[2]");
			$files_count = count($files)-2;
			echo "<td>$files_count</td>";
			echo "</tr>";
		} else {
			if ($arr_line[2] == $number) {
				$files = scandir("./details/$arr_line[2]");
				$files_count = count($files)-2;
				echo "<tr>";
				foreach($arr_line as $cell) {
					echo "<td>$cell</td>";
				}
				echo "<td>$files_count</td>";
				echo "</tr>";
			}	
		
		}
	}
	fclose($file);
?>
				</tbody>
				</table>

<!-- view.php for displaying overall information end -->

<!-- view.php for displaying specific member start -->

<?php 
	if ($number && !$edit) {
			echo "<p><a class=\"btn\" href=\"view1.php \"><i class=\"icon-arrow-left\"></i>返回列表</a></p>";
			echo "<h2><a class='btn btn-success' href='view1.php?number=$number&edit=true'><i class='icon-pencil icon-white'></i>添加/修改你的记录</a></h2>";
			if ($photo_file = fopen("details/$number/photo","r")) {
				?>
					<div class="row pull-right">
				<?php
				while($photo_src = fgets($photo_file)) {
				?>
						<img class="span2" src="<?php echo $photo_src; ?>"></img>
				<?php 
				} ?>
					</div>
				<?php }
			if ($files = scandir("./details/$number")) {
					foreach( $files as $index=>$file_name ) {
						if ($index > 1) {
							$file = str_replace("\n","<br />",file_get_contents("details/$number/$file_name"));
							echo "<blockquote>";
							echo "<p>$file</p>";
							echo "<small>$file_name 的记录</small>";
							echo "</blockquote>";
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

<!-- view.php for displaying specific member end -->

<!-- view.php for displaying comments start -->
				<p><a class="btn" href="view1.php?number=<?php echo $number?>"><i class="icon-arrow-left"></i>返回评论列表</a></p>

				<form id='formId' class="well form-horizontal" action='addinfo.php' action='post'>
						<label class="row">
							<span class="span2">学号:</span>
							<span class="span3">
								<input type="text" id="number"  name="number" value="<?php echo $number; ?>" readonly="readonly"></input>
							</span>
						</label>
						<label class="row">
							<span class="span2">你的名字:</span>
							<span class="span5">
								<input class="span3" type="text" id="name" name="name" value="<?php echo $_SESSION['name']; ?>" readonly="readonly"></input>
								<span id="msg" class="label label-success" style="display:none;">
								</span>
							</span>

						</label>
						<label class="row">
							<span class="span2">记录一下吧:</span>
							<span class="span6">
								<textarea id="content" class="span6" name="content" rows="10"></textarea>
							</span>
						</label>
					
						<button type="submit" class="btn btn-primary" id="submit">保存</button>
				</form>
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
		</div>
		<!-- container end -->
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
				$("#msg").delay(2000).fadeOut();
			}
		});
		return false;
	});

	$(document).ready(function() {
		$(".tablesorter").tablesorter();
		$(".alert").show("shake",{},500,function(){});
	});
	</script>
</html>
