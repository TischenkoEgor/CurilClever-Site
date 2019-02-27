<div class="header_container">
	<div class="site_logo">
		<img id="logoimg" src="pic/logo.png" alt="логотип">
	</div>
	<div class="menucontainer">
		<h1> Эксклюзивное турагенство Курил Клевер </h1>
		<ul class="menulist">
			<li><a href="index.php">главная</a></li>
			<li><a href="orders.php">управение заявками</a></li>
			<li><a href="tours.php">управление турами</a></li>
			<li><a href="hotels.php">управление отелями</a></li>
			<li><a href="createorder.php">добавить заявку</a></li>
		</ul>
	</div>
	<div class="contact_container">
		<a id="calllink" href="#"><h3>заказать звонок</h3> </a>
		<hr>
		<h3>+7 (654) 123 44 55</h3>
		<?
			if(isset($_SESSION['userid']))    
			{
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
					id=".$_SESSION['userid'];
				$result = mysqli_query($link, $query) or die("Ошибка ".mysqli_error($link));
				
				$result = mysqli_fetch_assoc($result);
				if(count($result))
				{
					?>
					<p> вы вошли как <?echo $result["username"]?>
					<a href="logout.php">Выйти</a> </p>
					<?
				}
			}
		?>
	</div>
</div>