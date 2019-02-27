<?require "auth.php";
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
					<a  class="allitemslink" href="allorders.php">просмотр всех</a>
				</div>
				<div class="preview" id="LastTours">
					<h3>Последние туры</h3>	
					<?
						$link = mysqli_connect($host, $user, $password, $database) 
						or die("Ошибка " . mysqli_error($link));

						// выполняем операции с базой данных
						$query =
						"SELECT 
							tours.id AS id, 
							clients.first_name AS person_first_name, 
							clients.second_name AS person_second_name, 
							hotels.name AS hotel_name, 
							tours.begin_date AS begin_date, 
							tours.end_date AS end_date, 
							tours.comment AS comment, 
							tours.price AS price, 
							tours.pay_status AS pay_status
						FROM 
							tours
						INNER JOIN clients ON client_id = clients.id
						INNER JOIN hotels ON hotel_id = hotels.id
						ORDER BY tours.id DESC
						LIMIT 10";

						$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
						if($result)
						{
							while($row = mysqli_fetch_array($result)) 
							{
								?>
								<div> 
									<a class="tour_link" href="edittour.php?tourid=<?echo $row['id'];?>">
									<p class="tourpreview">
										<? echo $row['id'].' ';
											echo $row['person_first_name'].' '.$row['person_second_name'].' с ';
											echo date('Y-m-d', strtotime($row['begin_date'])).' по ';
											echo date('Y-m-d', strtotime($row['end_date'])).' ';
											echo $row['hotel_name']; ?></p>
									</a>
								</div>
								<?
							}
						}
					?>
					<hr>
					<a href="tours.php"  class="allitemslink"> просмотр всех </a>

				</div>
				<div class="preview" id="TopHotels">
					<h3>Популярные отели</h3>	

					<?
					// подключаемся к серверу
					$link = mysqli_connect($host, $user, $password, $database) 
					or die("Ошибка " . mysqli_error($link));

					// выполняем операции с базой данных
					$query ="SELECT * FROM hotels LIMIT 10";
					$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
					if($result)
					{
						while($row = mysqli_fetch_array($result)) 
						{
							
							?>
							<div> 
							
							<a class="tour_link" href="edithotels.php?id=<?echo $row['id']?>"> 
							<?
								echo $row['stars_rate'].'* '.$row['name'].' '.$row['price'].'$' ; 
							?>
							</a>
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
					<a href="hotels.php" class="allitemslink"> просмотр всех </a>
				</div>
				<div id="touristtraveltoday">
					<h3>Туристы в путешествии на сегодня</h3>
					<?
						$link = mysqli_connect($host, $user, $password, $database) 
						or die("Ошибка " . mysqli_error($link));

						// выполняем операции с базой данных
						$query =
						"SELECT 
							tours.id AS id, 
							clients.first_name AS person_first_name, 
							clients.second_name AS person_second_name, 
							clients.phone AS phone,
							hotels.name AS hotel_name, 
							hotels.stars_rate AS stars_rate,

							tours.begin_date AS begin_date, 
							tours.end_date AS end_date, 
							tours.comment AS comment, 
							tours.price AS price, 
							tours.pay_status AS pay_status
						FROM 
							tours
						INNER JOIN 
							clients ON client_id = clients.id
						INNER JOIN 
							hotels ON hotel_id = hotels.id
						WHERE
							tours.begin_date <=  NOW()  and tours.end_date >= NOW() and tours.pay_status = 2
						ORDER BY tours.id DESC";

						$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
						if($result)
						{
							$n=0;
							while($row = mysqli_fetch_array($result)) 
							{
								?>
								<div> 
									<a class="tour_link" href="edittour.php?tourid=<?echo $row['id'];?>">
									<p class="tourpreview">
										<?  echo $row['id'].' ';
											echo $row['person_first_name'].' '.$row['person_second_name'].' с ';
											echo date('Y-m-d', strtotime($row['begin_date'])).' по ';
											echo date('Y-m-d', strtotime($row['end_date'])).' ';
											echo $row['hotel_name'].' ';
											echo $row['stars_rate'].'* <b>контактный телефон клиента: ';
											echo $row['phone'].'</b>';

										?></p>
									</a>
								</div>
								<?
								$n++;
							}
							if($n == 0)
							{
								?>
									<p>На текущую дату нет исполняемых туров</p>
								<?
							}
						}
						
					?>
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
