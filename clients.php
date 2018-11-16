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
            <H2>Клиенты агенства</H2> 
            <br>
            <table border="1" width='1250'>
                <tr>
                    <td>ИД</td>
                    <td>ФИО</td>
                    <td>Возраст/Пол</td>
                    <td>Телефон</td>
                    <td>Управление</td>
                </tr>
                <?
                // подключаемся к серверу
                $link = mysqli_connect($host, $user, $password, $database) 
                or die("Ошибка " . mysqli_error($link));

                // выполняем операции с базой данных
                $query ="SELECT * FROM clients order by id desc";
                $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
                if($result)
                {
                    while($row = mysqli_fetch_array($result)) 
                    {
                    
                        ?>
                        <tr>
                            <td><? echo $row['id']?></td>
                            <td><? echo $row['first_name'].' '.$row['second_name'];?> </td>
                            <td><? echo $row['age'].' / ';if($row['sex']) echo 'Муж'; else echo 'Жен';?></td>
                            <td><? echo $row['phone']?></td>
                            <td><? echo "<a href=\"editclient.php?id=".$row['id']."\"> изменить </a>"?></td>
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
