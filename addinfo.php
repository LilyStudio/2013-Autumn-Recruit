<?php 
	$number = $_REQUEST['number'];
	$name = $_REQUEST['name'];
	$content = $_REQUEST['content'];
	$file = fopen("$number/$name",'w') or exit("Cannot open $name");
	fputs($file,$content);
	fclose($file);
	echo 'finish!';
