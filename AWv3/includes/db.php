<?php

		$host 		= 'localhost';
		$db			= 'ex-aw2';
		$username 	= 'root';
		$password 	= '';
		$charset 	= 'utf8mb4';

	try{
		$conn = new PDO("mysql:host=$host;dbname=$db;charset=$charset;", $username, $password);
	} catch (PDOException $e){
		die('Connection Failed: ' . $e->getMessage());
	}

?>