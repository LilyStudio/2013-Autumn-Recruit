<?php 
	$number = $_REQUEST['number'];
	$name = $_REQUEST['name'];
	$content = $_REQUEST['content'];
	file_put_contents("$number/$name",$content) or exit("Cannot open $name");
	echo 'successd!';
