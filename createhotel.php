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

        <?
            if(
                isset($_POST['name']) && strlen($_POST['name']) > 1 &&
                isset($_POST['addres']) && strlen($_POST['addres']) > 3 &&
                isset($_POST['cost']) && strlen($_POST['cost']) > 0 && is_numeric($_POST['cost']) &&
                isset($_POST['location']) && strlen($_POST['location']) > 0 &&
                isset($_POST['stars_rate']) && strlen($_POST['stars_rate']) > 0 && is_numeric($_POST['stars_rate']))
            {
                echo ("<p style='color:green'> Все данные введены верно!!</p> ");
                // добавление в базу
               
                //1. подключаемся к серверу
                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
				$link = mysqli_connect($host, $user, $password, $database) 
                or die("Ошибка " . mysqli_error($link));
                //2. создадим шаблон запроса
                $sql = "INSERT INTO hotels ( name, addres, price, location, stars_rate)
                        VALUES (?,?,?,?,?);";
                //3. подготовим запрос       
                 $stmt = mysqli_prepare($link, $sql);  
                //4. вставим данные из формы 
                
                $stmt->bind_param("ssiii",$_POST['name'], $_POST['addres'], $_POST['cost'], $_POST['location'],$_POST['stars_rate']);
                $stmt->execute();
                echo ("<p style='color:green'> Данные отеля добавлены в базу данных !!</p> ");    
            }
            
            else if(
                isset($_POST['name']) ||
                isset($_POST['addres']) || 
                isset($_POST['cost']) || 
                isset($_POST['location']) ||
                isset($_POST['stars_rate']))
            {
                echo ("<p style='color:red'> ошибка ввода данных!!</p> ");
            }


        ?>


        <H2>Добавить отель в базу</H2>
        <fieldset>
            <legend>Данные отеля</legend>
            <form action="createhotel.php" method="post" name="createhotelform">
                <p><label>Название:<input name="name" size="30" type="text"></label></p>
                <p><label>Адрес:<input name="addres" size="50" type="text"></label></p>
                <p><label>Стоимость:<input name="cost" size="30" type="text"></label></p>
                <p><label> Расположение:  <select name="location">
                    <?
                     // подключаемся к серверу
					$link = mysqli_connect($host, $user, $password, $database) 
					or die("Ошибка " . mysqli_error($link));

					// заюираем все расположения из базы данных
					$query ="SELECT * FROM locations";
                    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));  
                    while($location = mysqli_fetch_array($result))
                    {
                        ?>
                        <option value="<?echo $location['id'];?>"><?echo $location['location_name'];?></option>
                        <?
                    }
                    ?>
                </select></label></p>
                <p><label> Звезд:  <select name="stars_rate">
                    <?
                   
                    for($i = 1; $i <= 5; $i++ )
                    {
                        ?>
                        <option value="<?echo $i;?>" ><?echo $i.' *';?></option>
                        <?
                    }
                    ?>
                </select></label></p>
                <p><input name="register" type="submit" value="Добавить"></p>
            </form>
        </fieldset>
        </div>
        <footer>
			<?php
				require "footer.php";
			?>
		</footer>
	</body>
</html>
