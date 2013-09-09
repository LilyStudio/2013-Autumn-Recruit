<?php 
	$name = $_REQUEST["name"];
	$number = $_REQUEST["number"];
	$dept = $_REQUEST["dept"];
	$group = $_REQUEST["group"];
	$phone = $_REQUEST["phone"];
	$question = $_REQUEST["question"];
	$keyword_list = array('AND','OR','=','WHERE','SELECT','>','<','\'');
	$arr_user_input = array_merge(split(" ",$name),split(" ",$number),split(" ",$dept),split(" ",$group),split(" ",$phone),split(" ",$question));
	foreach ($arr_user_input as $user_input) {
		if (in_array(strtoupper($user_input), $keyword_list)) {
			echo "The database has been changed. Query Success!";
			die();
		}
	}
	echo "Welcome $name !";
	echo "Your Information has been sent.";
	$file = fopen("table.txt","a") or exit("Unable to open file!");
	fputs($file,"$name\t$number\t$dept\t$phone\t$group\t$question");
	fputs($file,"\r\n");
	fclose($file);
