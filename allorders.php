<?
    require "auth.php";
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
            <H2>Все заявки агенства</H2> 
            <br>
            <table border="1" width='1250'>
                <tr>
                    <td><b>Имя</b></td>
                    <td><b>Фамилия</b></td>
                    <td><b>Название отеля</b></td>
                    <td><b>Заявка от</b></td>
                    <td></td>
                </tr>
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
						ORDER BY  orders.order_registration_date DESC";

					$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
                if($result)
                {
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
