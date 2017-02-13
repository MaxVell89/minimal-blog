<?php

$connect = mysqli_connect(
	$config['db']['server'],
	$config['db']['username'],
	$config['db']['password'],
	$config['db']['name']
);

if ($connect == false) {
	echo 'Не удалось подключится к БД';
	echo mysqli_connect_error();
	exit();
}