<?php
	session_start();

	//подключаемся к БД
    $host = 'localhost';
    $db   = 'miniforum';
    $user = 'root';
    $pass = '';
    $charset = 'utf8';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    $connection = new PDO($dsn, $user, $pass)  or die ("Ошибка " . mysqli_error($connection));

    $date = $connection->query("SELECT * FROM admin");

    //проверяем логин пароль
    if ($_POST['login']) {
    	foreach ($date as $info) {
    		if ($_POST['login'] == $info['login'] && $_POST['password'] == $info['password']) {
    			$_SESSION['login'] = $_POST['login'];
    			header("Location: admin.php");
    		}
    	}
    	

    }

    // echo "<pre>";
    // var_dump($_SESSION);
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
	.login-off {
		display: none;
	}
	.login-on {
		display: block;
	}
</style>
<body>	
	<div class="wrap">
		<ul>
			<li><a href="index.php">форум</a></li>
			<li><a href="login.php">авторизация</a></li>
			<li><a href="admin.php">админка</a></li>
		</ul>
		<h2 class = "<?= $_SESSION['login']? 'hidden-form' : ''?>">Для входа в админку введите логин и пароль</h2>
		<h2 class = "<?= $_SESSION['login']? 'login-on' : 'login-off'?>">Вы авторизованы</h2>

		<form action="" method="post" class = "<?= $_SESSION['login']? 'hidden-form' : ''?>">
			<p><?= $out ?></p>
			<p>Введите имя</p>
			<input type="text" name= "login" required>
			<p>Введите пароль</p>
			<input type="password" name="password" required>
			<p></p>
			<input type="submit">
		</form>
	<p>Надо поработать еще с prepare запросами PDO разобраться как это работает, понять почему на admin.php в коде "модерируем посты" посты обновляються только после двух кликов, сейчас обновляеться по одному но это из за header(), На странице форума сделать возможность администратору удалять сообщения</p>

	</div>

	
</body>
</html>