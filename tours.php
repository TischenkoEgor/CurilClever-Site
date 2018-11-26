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
            <a href="edittour.php?create=1">создать тур</a> 
            <br>
            <H2>Все туры агенства</H2> 
            <br>
            <table border="1" width='1250'>
                <tr>
                    <td><b>№</b></td>
                    <td><b>Клиент</b></td>
                    <td><b>Дата въезда</b></td>
                    <td><b>Дата выезда</b></td>
                    <td><b>Отель</b></td>
                    <td></td>
                </tr>
                <?
                // подключаемся к серверу
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
                    INNER JOIN 
                        clients ON client_id = clients.id
                    INNER JOIN 
                        hotels ON hotel_id = hotels.id
                    ORDER BY tours.id DESC";

					$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
                if($result)
                {
                    while($row = mysqli_fetch_array($result)) 
                    {
                    
                        ?>
                        <tr>
                            <td><? echo $row['id'];?></td>
                            <td><? echo $row['person_first_name'].' '.$row['person_second_name'];?></td>
                            <td><? echo date('Y-m-d', strtotime($row['begin_date']));?></td>
                            <td><? echo $row['end_date'];?></td>
                            <td><? echo $row['hotel_name'];?></td>
                            <td><a href="edittour.php?tourid=<?echo $row['id'];?>"> управление </a></td> 
                        </tr>
						<?
                    }
                    // очищаем результат
                    mysqli_free_result($result);
                }
                // закрываем подключение
                mysqli_close($link); 
                ?>
            
            </table>
        </div>
        <footer>
			<?php
				require "footer.php";
			?>
		</footer>
	</body>
</html>
