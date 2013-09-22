<?php
	$number = $_REQUEST['number'];
	$name = $_REQUEST['name'];
	$content = file_get_contents("details/$number/$name") or "";
	echo $content;
