<?php

include('includes/db.php');

$login = $_POST['login'];
$pass = $_POST['password'];

$users_db = mysqli_query($connection, "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$pass'");

if (mysqli_num_rows($users_db) == 0) {
	echo 'Ваш логин или пароль не верен';
} else {
	echo "Здравствуйте";
}
