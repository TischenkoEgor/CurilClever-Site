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
				<h2>Главная страница: управление экспресс-турами</h2>
			</div>
			<div id="preview1stline">
				<div class="preview" id="orders">
					<h3>Последние заявки</h3>
					<?
					// подключаемся к серверу
					$link = mysqli_connect($host, $user, $password, $database) 
					or die("Ошибка " . mysqli_error($link));

					// выполняем операции с базой данных
					$query ="SELECT * FROM clients";
					$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
					if($result)
					{
						while($row = mysqli_fetch_array($result)) 
						{
							
							?>
							<div > <p class="ordershortview">
							<?
								echo $row['first_name'].' '.$row['second_name'].' '.$row['email']; 
							?>
							</p></div>
							<?
						}
						
						
						// очищаем результат
						mysqli_free_result($result);
						
					}
					// закрываем подключение
					mysqli_close($link); 
					?>
				</div>
				<div class="preview" id="tours">
					<h3>Последние туры</h3>	
				</div>
				<div class="preview" id="hotels">
					<h3>Популярные отели</h3>	
					
					<?
					// подключаемся к серверу
					$link = mysqli_connect($host, $user, $password, $database) 
					or die("Ошибка " . mysqli_error($link));

					// выполняем операции с базой данных
					$query ="SELECT * FROM hotels";
					$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
					if($result)
					{
						while($row = mysqli_fetch_array($result)) 
						{
							
							?>
							<div> 
							<?
								echo $row['name'].' '.$row['price'].' '.$row['stras_rate'].'*' ; 
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
