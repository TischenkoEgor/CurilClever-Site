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
           <H2>Создать</H2>
           <div>
                <a href="createclient.php">создать клиента</a>
                <a href="createorder.php">создать заявку</a>
           </div>
           
           <div id="preview1stline">
                <div class="preview" id="orders">
					<H2>Клиенты</H2>
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
							<div> 
							<?
								echo $row['first_name'].' '.$row['second_name']; 
							
							echo "<a href=\"editclient.php?id=".$row['id']."\"> изменить </a>";  
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
				<div class="preview" id="orders" style="width:650px;">
				<H2>Последние заявки</H2>
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
						order_registration_date
						FROM orders
							INNER JOIN clients 
								ON person_id = clients.id
							INNER JOIN hotels 
								ON hotel_id = hotels.id
						ORDER BY  orders.order_registration_date DESC
						LIMIT 10";

					$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
					if($result)
					{
						?>
						<table border="1" width="630">
							<tr>
								<td><b>Имя</b></td>
								<td><b>Фамилия</b></td>
								<td><b>Название отеля</b></td>
								<td><b>Заявка от</b></td>
								<td></td>
							</tr>
							
								
						<?
						while($row = mysqli_fetch_array($result)) 
						{
						
							?>
							<tr>
								<td><? echo $row['person_first_name'];?></td>
								<td><? echo $row['person_second_name'];?></td>
								<td><? echo $row['hotel_name'];?></td>
								<td><? echo $row['order_registration_date']; ?></td>
							
								<td><a href="controlorder.php?id=<?echo $row['order_id'];?>"> управление </a></td> 
							</tr>
							<?
						}
						?>
						</table>
						<?
						// очищаем результат
						mysqli_free_result($result);
					}
					// закрываем подключение
                    mysqli_close($link); 
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
