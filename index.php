<?php 
	//подключаемся к БД
    $host = 'localhost';
    $db   = 'miniforum';
    $user = 'root';
    $pass = '';
    $charset = 'utf8';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    $connection = new PDO($dsn, $user, $pass)  or die ("Ошибка " . mysqli_error($connection));;

    //принимаем и отправляем запрос (сообщение в БД)
    $out = '';
    if ($_POST['username']) {
    	$username = htmlspecialchars($_POST['username']);
    	$message = htmlspecialchars($_POST['message']);
    	$connection->query("INSERT INTO comments (`username`, `comment`) VALUES ('$username', '$message')");
    	//$out = "Сообщение получено и будет проверено модератором!";
    	header("Location: " . $_SERVER['REQUEST_URI']);
    }

    // вытаскиваем все посты из бд
    $allComments = $connection->query("SELECT * FROM comments WHERE moderation = 'ok' ORDER BY date DESC");

    // echo "<pre>";
    // var_dump($allComments);
    // echo "</pre>";

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>forum</title>
</head>
<style>
	.wrap {
		width: 1024px;
		margin: 50px auto 0;
	}
	input {
		display: block;
	}
	ul {
		display: -webkit-flex;
		display: -moz-flex;
		display: -ms-flex;
		display: -o-flex;
		display: flex;
		justify-content: space-around;
		list-style: none;
	}
	.hidden-form {
		display: none;
	}
</style>
<body>	
	<div class="wrap">
		<ul>
			<li><a href="index.php">форум</a></li>
			<li><a href="login.php">авторизация</a></li>
			<li><a href="admin.php">админка</a></li>
		</ul>
		<h2>Добро пожаловать на форум</h2>

		<form action="" method="post">
			<p><?= $out ?></p>
			<p>Введите имя</p>
			<input type="text" name= "username" required>
			<p>Введите сообщение</p>
			<textarea name="message" id="" cols="30" rows="10" required></textarea>
			<input type="submit">
		</form>
		<hr>
		<h4>Все сообщения проходят модерацию</h4>
		<p>Сообщения от пользователей</p>
		<?php 
		//
		foreach ($allComments as $comment) {
			echo "<p>Сообщение <b>" . $comment['comment'] . "</b></p> <p>от <b>" . $comment['username'] . "</b></p> <p>дата <b>" . $comment['date'] ."</b></p><hr>";
		}
		 ?>
	</div>

	
</body>
</html>


