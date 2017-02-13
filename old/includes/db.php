<?php

$connection = mysqli_connect('127.0.0.1', 'root', '', 'test_bd');

if ($connection == false) {
	echo 'Нет соединения с БД';
	echo mysqli_connect_error();
	die();
}

