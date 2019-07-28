<?php
	session_start();
	if (!$_SESSION['login']) {
		header("Location: login.php");
		exit();
	}

	if ($_POST['unlogin']) {
		session_destroy();
		header("Location: login.php");
	}

	//обновляем POST
	if (count($_POST) > 0)
	{
		header("Location: admin.php");
	}

	// echo "<pre>";
 //    var_dump($_POST);
 //    echo "</pre>";


	//подключаемся к БД
    $host = 'localhost';
    $db   = 'miniforum';
    $user = 'root';
    $pass = '';
    $charset = 'utf8';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    $connection = new PDO($dsn, $user, $pass)  or die ("Ошибка " . mysqli_error($connection));
	$allComments = $connection->query("SELECT * FROM comments WHERE moderation = 'new' ORDER BY date DESC");


	//модерируем посты
	foreach ($_POST as $num => $checked) {
		if ($checked == 'ok')
		{
			$allComments = $connection->query("UPDATE comments SET moderation='ok' WHERE id=$num");
			//header("Location: admin.php");
		}
		else
		{
			$allComments = $connection->query("UPDATE comments SET moderation='rejected' WHERE id=$num");
			//header("Location: admin.php");
		}
	}





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

</style>
<body>	
	<div class="wrap">
		<ul>
			<li><a href="index.php">форум</a></li>
			<li><a href="login.php">авторизация</a></li>
			<li><a href="admin.php">админка</a></li>
		</ul>
		<h2>Админка</h2>

		<form action="" method="post">
			<p><?= $out ?></p>
			<p>Разлогиниться</p>
			<input type="submit" name="unlogin" value="unlogin">
		</form>
		<hr>
		<h4>Сообщения для модерации</h4>

		<form method="post">
			<?php foreach ($allComments as $comment): ?>
		
			<select name="<?=$comment['id']?>" id="<?=$comment['id']?>">
				<option value="ok">ok</option>
				<option value="rejected">отклонить</option>
			</select>
				<label for="<?=$comment['id']?>">
					<?= "<b>" . $comment['username'] . " </b>оставил коментарий<b> " . $comment['comment'] . "</b><br>"?>
				</label>
			

			<?php endforeach ?>
			<input type="submit" value="moderate">
		</form>

	</div>

	
</body>
</html>