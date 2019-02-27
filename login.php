<?
require "config.php";
require "functions.php";

// авторизация если идет запрос со страницы login.php
if(isset($_POST['login']) && isset($_POST['password']))
{
    // фильтруем SQL инъекции
    $safety_login = quote($_POST['login']);
    $safety_password = md5(quote($_POST['password']));

    // 1. подключаемся к серверу
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $link = mysqli_connect($host, $user, $password, $database) 
        or die("Ошибка " . mysqli_error($link));
	// 2. выполняем операции с базой данных
	$query = 
	"SELECT * 
	FROM 
		users 
	WHERE 
		username='$safety_login' AND pass='$safety_password'";
	$result = mysqli_query($link, $query) or die("Ошибка ".mysqli_error($link));
	
	$result = mysqli_fetch_assoc($result);
    if(count($result))
    {
		session_start();
        // если нашелся в БД пользователь с таким паролем и логином, то:
		$_SESSION['userid'] = $result['id'];

		// отправляем пользователя в ж.. на главную страницу
		ob_start();
		$new_url = 'index.php';
		header('Location: '.$new_url);
		ob_end_flush();
    }
}   
?>
<html>
	<head>
		<? require "head.php"; ?>
		<title> Турагенство Курил Клевер </title>
	</head>
	<body>
		<header>
			<?php
				require "header.php";
			?>
		</header>

		<div class="page">
			<div style="text-align: center">
				<h2>Вход на корпоративный портал</h2>
			</div>
			<fieldset>
                <legend>Учетная запись</legend>
               
                <form action="login.php" name="login_form">
                    <p><label>Логин</label><input type="name" name="login" placeholder="логин" require></p>                     
                    <p><label>Пароль</label><input type="password" name="password" placeholder="пароль" require></p>
                    <input type="submit" name="submit" value="вход" formmethod="post">
                </form>
            </fieldset>

            <p>Если тебе Босс еще не дал логин и пароль, то можешь вежливо его попросить (или занести пивка админу)</p>
            <p>Если ты забыл логин или пароль - можешь смело брать вещи и идти на**й, да, и чашку захвати.</p>
            <p>Если ты вообще не из курил клевер то уё****ай отсюда на****й</p>
		</div>

		<footer>
			<?php
				require "footer.php";
			?>
		</footer>
	</body>
</html>
