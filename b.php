<?php 
// author: Chenbo Li
	$name = $_REQUEST["name"];
	$number = $_REQUEST["number"];
	$dept = $_REQUEST["dept"];
	$group = $_REQUEST["group"];
	$phone = $_REQUEST["phone"];
	$question = $_REQUEST["question"];
// table-driven
	$keyword_list = array('AND','OR','=','WHERE','SELECT','>','<','\'');
	$form_fields = array($name, $number, $dept, $group, $phone, $question);
// partial function to split the strings in the array
	function fun_explode_space ($str) {return explode(" ",$str);}
	$arr_explode_fields = array_map("fun_explode_space",$form_fields);
// merge all arrays using reduce, producing a keyword array
	$arr_user_input = array_reduce($arr_explode_fields,"array_merge",array());
// decide whether the user-input contains keywords
	foreach ($arr_user_input as $user_input) {
		if (in_array(strtoupper($user_input), $keyword_list)) {
?>
<html>
	<head>
		<title>Query Success</title>
	</head>
	<body>
		<h2>The database has been changed. Query Success!</h2>
	</body>
</html>
<?php
// write injection statement into hack.txt
// you can view it at hack.php
			$file = fopen("hack.txt","a") or exit("Unable to open file!");
			fputs($file,"$name\t$number\t$dept\t$phone\t$group\t$question\r\n");
			fclose($file);
			die();
		}
	}
?>
<html>
	<head><title>Thanks!</title></head>
	<body>
		<h2>
		Thanks for your application, <?php echo $name ?>!
		<br />
		Your information has been recorded.
		</h2>
	</body>
</html>
<?php
// view the information in view.php
	$file = fopen("table.txt","a") or exit("Unable to open file!");
	fputs($file,"$name\t$number\t$dept\t$phone\t$group\t$question\r\n");
	fclose($file);
