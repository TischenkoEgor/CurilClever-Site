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
				<h2>Главная страница: управление турами</h2>
			</div>
			<div id="preview1stline">
				<div class="preview" id="LastOrders">
					<h3>Последние заявки</h3>
					<?
					// подключаемся к серверу
					$link = mysqli_connect($host, $user, $password, $database) 
					or die("Ошибка " . mysqli_error($link));

					// выполняем операции с базой данных
					$query ="SELECT
						orders.orderid AS order_id,
						clients.first_name AS person_first_name, 
						clients.second_name AS person_second_name, 
						hotels.name AS hotel_name,
						order_registration_date as reg_date
						FROM orders
							INNER JOIN clients 
								ON person_id = clients.id
							INNER JOIN hotels 
								ON hotel_id = hotels.id
						ORDER BY  orders.order_registration_date DESC
						LIMIT 6";
					$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
					if($result)
					{
						while($row = mysqli_fetch_array($result)) 
						{
							
							?>
							<div > <p class="ordershortview">
							<?
								echo 'в '.$row['hotel_name'].' от '.$row['reg_date']; 
							?>
							<a href="controlorder.php?id=<? echo $row['order_id'] ?>">просм</a>
							</p></div>
							<?
						}
						// очищаем результат
						mysqli_free_result($result);
						
					}
					// закрываем подключение
					mysqli_close($link); 
					?>
					<hr>
					<a href="allorders.php">просмотр всех</a>
				</div>
				<div class="preview" id="LastTours">
					<h3>Последние туры</h3>	
				</div>
				<div class="preview" id="TopHotels">
					<h3>Популярные отели</h3>	
					
					<?
					// подключаемся к серверу
					$link = mysqli_connect($host, $user, $password, $database) 
					or die("Ошибка " . mysqli_error($link));

					// выполняем операции с базой данных
					$query ="SELECT * FROM hotels LIMIT 14";
					$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
					if($result)
					{
						while($row = mysqli_fetch_array($result)) 
						{
							
							?>
							<div> 
							<?
								echo $row['stars_rate'].'* '.$row['name'].' '.$row['price'].'$' ; 
							?>
							</div>
							<?
						}
						
						
						// очищаем результат
						mysqli_free_result($result);
						
					}
					// закрываем подключение
					mysqli_close($link); 
					?>
					<hr>
					<a href="hotels.php"> просмотр всех </a>
				</div>
				<div id="touristtraveltoday">
					<h3>Туристы в путешествии на сегодня</h3>

				</div>
			</div>
			

		</div>

		<footer>
			<?php
				require "footer.php";
			?>
		</footer>
	</body>
</html>
