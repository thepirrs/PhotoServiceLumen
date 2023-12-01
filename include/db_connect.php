<?php

	$db_host = "localhost";
	$db_user = "ziminv4z_lum";
	$db_password = "WCHyf1f%";
	$db_database = "ziminv4z_lum";

$mysqli = new mysqli($db_host, $db_user, $db_password, $db_database);
	
	if ($mysqli -> connect_error) {
		printf("Соединение не удалось: %s\n", $mysqli -> connect_error);
		exit();
	};

	
?>