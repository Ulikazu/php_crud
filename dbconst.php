<?php

$server = 'localhost';
$db_username = 'root';
$db_password = 'root';
$database = 'mydb';


try {
	$link = new PDO("mysql:host=$server;port=3306;dbname=$database;charset=utf8;", $db_username, $db_password);

} catch (PDOException $e) {
	die("Connection failed".$e->getMessage());
	
}