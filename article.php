<?php
  require ('includes/config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Блог IT_Минималиста!</title>

  <!-- Bootstrap Grid -->
  <link rel="stylesheet" type="text/css" href="media/assets/bootstrap-grid-only/css/grid12.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

  <!-- Custom -->
  <link rel="stylesheet" type="text/css" href="media/css/style.css">
</head>
<body>

  <div id="wrapper">

<?php 
  include 'includes/header.php';

  $article = mysqli_query($connect, 'SELECT * FROM `articles` WHERE `id` =' . (int) $_GET['id']);
  if (mysqli_num_rows($article) <= 0) {
?>

<div id="content">
      <div class="container">
        <div class="row">
          <section class="content__left col-md-8">
            <div class="block">
              <a>232 000 просмотров</a>
              <h3>Статья не найдена!</h3>
              <div class="block__content">
                <img src="/media/images/post-image.jpg">

                <div class="full-text">
                  Запрашиваемой вами статьи не существует.
                </div>
              </div>
            </div>

<?php
  } else {
    $art = mysqli_fetch_assoc($article);
    mysqli_query($connect, 'UPDATE `articles` SET `view` = `view` + 1 WHERE `id` = ' . (int) $art['id']);
?>

  <div id="content">
      <div class="container">
        <div class="row">
          <section class="content__left col-md-8">
            <div class="block">
              <a><?php echo $art['view'] ?> просмотров</a>
              <h3><?php echo $art['title']; ?></h3>
              <div class="block__content">
                <img src="static/images/<?php echo $art['image']; ?>" width="100%" height="auto">

                <div class="full-text">
                  <?php echo $art['text']; ?>
                </div>
              </div>
            </div>

<div class="block">
  <a href="#comment-add-form">Добавить свой</a>
  <h3>Комментарии к статье</h3>
  <div class="block__content">
    <div class="articles articles__vertical">

    <?php 
      $comment = mysqli_query($connect, 'SELECT * FROM `comments` WHERE `article_id` = ' . (int) $art['id'] . ' ORDER BY `id` DESC');

      if (mysqli_num_rows($comment) == 0) {
    ?>

      <article class="article">
        <p>Комментариев нет</p>
      </article>

    <?php
      } else {

      while ($com = mysqli_fetch_assoc($comment)) {
    ?>

      <article class="article">
        <div class="article__image" style="background-image: url(https://www.gravatar.com/avatar/<?php echo md5($com['email']); ?>?s=125);"></div>
        <div class="article__info">
          <a href="#"><?php echo $com['author'] ?></a>
          <div class="article__info__meta">
            <small>10 минут назад</small>
          </div>
          <div class="article__info__preview"><?php echo $com['text']; ?></div>
        </div>
      </article>

    <?php
        }
      }
    ?>

    </div>
  </div>
  </div>

  <div class="block" id="comment-add-form">
  <h3>Добавить комментарий</h3>
  <div class="block__content">
    <form class="form" method="POST" action="/article.php?id=<?php echo $art['id']; ?>">
    <?php
      if ( isset($_POST['do_post']) ) {
        $errors = array();

        if ( $_POST['name'] == '') {
          $errors[] = 'Введите Ваше имя!';
        }

         if ( $_POST['nickname'] == '') {
          $errors[] = 'Введите Ваш ник!';
        }

         if ( $_POST['email'] == '') {
          $errors[] = 'Введите Ваш email!';
        }

         if ( $_POST['text'] == '') {
          $errors[] = 'Введите текст комментария!';
        }

        if ( empty($errors) ) {
          // Добавить комментарий
          mysqli_query($connect, "INSERT INTO `comments` (`author`, `nickname`, `email`, `text`, `date`, `article_id`) VALUES ('".$_POST['name']."', '".$_POST['nickname']."', '".$_POST['email']."', '".$_POST['text']."', 'NOW()', '".$art['id']."')");
          echo '<p style="color: green; font-weight: bold; margin-bottom: 10px;">Комментарий успешно добавлен!</p>';
        } else {
          // вывести ошибку
          echo '<p style="color: red; font-weight: bold; margin-bottom: 10px;">' . $errors['0'] . '</p>';
        }

      }
    ?>
      <div class="form__group">
        <div class="row">
          <div class="col-md-4">
            <input type="text" class="form__control" name="name" placeholder="Имя" value="<?php echo $_POST['name']; ?>">
          </div>
          <div class="col-md-4">
            <input type="text" class="form__control" name="nickname" placeholder="Никнейм" value="<?php echo $_POST['nickname']; ?>">
          </div>
          <div class="col-md-4">
            <input type="text" class="form__control" required="" name="email" placeholder="Email" value="<?php echo $_POST['email']; ?>">
          </div>
        </div>
      </div>
      <div class="form__group">
        <textarea name="text" required="" class="form__control" placeholder="Текст комментария ..."></textarea>
      </div>
      <div class="form__group">
        <input type="submit" class="form__control" name="do_post" value="Добавить комментарий">
      </div>
    </form>
  </div>
  </div>

<?php
  }
?>
          </section>

          <section class="content__right col-md-4">
           <?php include 'includes/sidebar.php'; ?>
          </section>

        </div>
      </div>
    </div>

  <?php include 'includes/footer.php'; ?>

  </div>

</body>
</html>