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
            <H2>Управление отелями</H2>
            <div class='hotelstablecontainer'>
                <table border="1">
                    
                    <tr>
                        <td><b>Отель</b></td>
                        <td><b>Звезды</b></td>
                        <td><b>Стоимость одного дня</b></td>
                        <td><b>Адрес</b></td>
                        <td><b>Расположение</b></td>
                        <td><b>Действия</b></td>
                    </tr>
                    <?
                    // подключаемся к серверу
					$link = mysqli_connect($host, $user, $password, $database) 
					or die("Ошибка " . mysqli_error($link));

					// выполняем операции с базой данных
					$query ="SELECT * FROM hotels join locations on location=locations.id order by hotels.id";
                    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));  
                    //узнаем число отелей в ответе из базы
                    $num_rows = mysqli_num_rows($result);
                    
                    if($num_rows==0)
                    {
                    ?>
                        <tr>
                            <td colspan="5"><p>Отелей нет!!!</p></td>
                        </tr>
                    <?
                    }
                    echo '<tr>';
                    while($hotel = mysqli_fetch_array($result))
                    {
                         ?><td><? echo $hotel['name']; ?></td><?  
                         ?><td><? echo $hotel['stars_rate'].'*'; ?></td><?  
                         ?><td><? echo $hotel['price'].' $'; ?></td><?  
                         ?><td><? echo $hotel['addres']; ?></td><?  
                         ?><td><? echo $hotel['location_name']; ?></td><?  
                         ?><td><a href="edithotels.php?id=<?echo $hotel['0']?>">редактировать </a><a href="#">удалить</a></td><?  
                         echo '</tr>';
                    }
                    
                    ?>
                </table>
            </div>

           <div>
                <a href="createhotel.php">ДОБАВИТЬ ОТЕЛЬ</a>
           </div>         

        </div>
        <footer>
			<?php
				require "footer.php";
			?>
		</footer>
	</body>
</html>
