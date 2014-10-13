<?php

class HTMLView {
	
	public function echoHTML($body) {
		
		echo "
			<!DOCTYPE html>
			<html lang='sv'>
			<head>
				<title>Medlemsregister</title>
				<meta charset='utf-8' />
				<link rel='stylesheet' type='text/css' href='main.css' />
			</head>
			<body>
			<h1><a href='index.php'>Medlemsregister</a></h1>
				$body
			</body>
			</html>";	
	}
}
