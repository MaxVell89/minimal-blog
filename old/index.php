<?php

include('includes/db.php');

$result  = mysqli_query($connection, 'SELECT * FROM `categories`');

$result_count = mysqli_num_rows($result);

echo 'Записей найдено: ' . $result_count;

?>

<ul>
	<?php 
		while ( ($cat = mysqli_fetch_assoc($result)) ) {
			$articles_cat = mysqli_query($connection, 'SELECT COUNT(`id`) AS `total_count` FROM `articles` WHERE `category_id` = ' . $cat['id']);
			
			$articles_count = mysqli_fetch_assoc($articles_cat);
			echo '<li>' . $cat['title'] . ' (' . $articles_count['total_count'] . ')</li>';
		}
	?>
</ul>

<form action="action.php" method="POST">
	<input type="text" name="login" placeholder="Введите ваш логин">
	<input type="text" name="password" placeholder="Введите ваш пароль">
	<input type="submit" value="Отправить">
</form>

<?php
	mysqli_close($connection);
?>