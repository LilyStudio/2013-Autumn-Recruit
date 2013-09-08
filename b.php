<?php 
	$name = $_REQUEST["name"];
	$id = $_REQUEST["id"];
	$department = $_REQUEST["department"];
	$category = $_REQUEST["category"];
	$contact = $_REQUEST["contact"];
	$keyword_list = array('AND','OR','=','WHERE','SELECT','>','<');
	echo "Welcome $name !";
	echo "Your Information has been sent.";
	$file = fopen("table.txt","a") or exit("Unable to open file!");
	fputs($file,"$name\t$id\t$department\t$category\t$contact");
	fputs($file,"\n");
	fclose($file);
