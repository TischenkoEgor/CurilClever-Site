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
        <?
        if(isset($_GET["id"]))
        {
            $hot_id = $_GET["id"];

            //1. подключаемся к серверу
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $link = mysqli_connect($host, $user, $password, $database) 
            or die("Ошибка " . mysqli_error($link));
            //2. создадим  запрос
            $query = "SELECT * FROM hotels WHERE hotels.id=".$hot_id;
            $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));     
            $result=mysqli_fetch_assoc($result);
            if(count($result))
            {
                $name = $result["name"];
                $addres  = $result["addres"];
                $price = $result["price"];
                $stars_rate = $result["stars_rate"];
                $location = $result["location"];
            }
            // закрываем подключение
            mysqli_close($link);

            $name_mes = "";
            $addres_mes  = "";
            $price_mes = "";
            $stars_rate_mes = "";
            $location_mes = "";
        }
        $error_num = 0;
        $input_num = 0;

        if(isset($_POST['name'])){
            $input_num++;
            $name = $_POST['name'];
            if(strlen($name) <= 3)
            {
                $name_mes = "Длина названия отеля
                 не менее 3 символов!";
                $error_num ++;
            }
        }

        if(isset($_POST['addres'])){
            $input_num++;
            $addres = $_POST['addres'];
            if(strlen($addres) <= 3)
            {
                $addres_mes = "Длина адреса не менее 3 символов!";
                $error_num ++;
            }
        }
        
        if(isset($_POST['price']) )
        {
            $input_num++;
            $price = $_POST['price'];
            if (strlen($price) == 0 || !is_numeric($price)){
                $price_mes = "не число или не введен!";
                $error_num ++; 
            }
        }
        if(isset($_POST['stars_rate']) )
        {
            $input_num++;
            $stars_rate = $_POST['stars_rate'];
            if ( strlen($stars_rate) == 0|| !is_numeric($stars_rate)){
                $stars_rate_mes = "не число или не введен!";
                $error_num ++; 
            }
        }
        if(isset($_POST['location']))
        {
            $input_num++;
            $location = $_POST['location'];
            if(strlen($location) == 0 || !is_numeric($location))
            {
                $location_mes = "не число или не введен!";
                $error_num ++;    
            }
        }
        if($error_num == 0 && $input_num > 0)
        {
            //1. подключаемся к серверу
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $link = mysqli_connect($host, $user, $password, $database) 
            or die("Ошибка " . mysqli_error($link));
            //2. создадим  запрос

            $query = "UPDATE hotels SET name=?,addres=?,price=?,stars_rate=?,location=? WHERE id=?";

            //3. подготовим запрос       
            $stmt = mysqli_prepare($link, $query);  
            //4. вставим данные из формы 
            
            $stmt->bind_param("ssiiii",$name, $addres, $price, $stars_rate, $location, $hot_id);
            $stmt->execute();
            echo_positive_msg("успеш6но обновлено, блеат!");
        }

        ?>
        <H2>Изменить отель</H2>
       
        <fieldset>
            <legend>Данные отеля</legend>
            <form action="edithotels.php?id=<?echo $hot_id;?>" method="post" name="edithotelform">
                <? echo_input_error($name_mes); ?>
                <p><label>Имя:<input name="name" type="text" value="<? echo $name;?>"></label></p> 

                <? echo_input_error($addres_mes); ?>
                <p><label>Адрес: <input name="addres" value="<? echo $addres;?>" size="30" type="text"></label></p>

                <? echo_input_error($price_mes); ?>
                <p><label>Цена:<input name="price" value="<? echo $price;?>" size="30" type="text"></label></p>
               
                <? echo_input_error($location_mes); ?>
                <p><label> Расположение:  <select name="location">
                    <?
                     // подключаемся к серверу
					$link = mysqli_connect($host, $user, $password, $database) 
					or die("Ошибка " . mysqli_error($link));

					// заюираем все расположения из базы данных
					$query ="SELECT * FROM locations";
                    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));  
                    while($location_all = mysqli_fetch_array($result))
                    {
                        ?>
                        <option value="<?echo $location_all['id'];?>" <?if($location_all['id'] == $location) echo ' selected';?>><?echo $location_all['location_name'];?></option>
                        <?
                    }
                    ?>
                </select></label></p>


                <? echo_input_error($stars_rate_mes); ?>
                <p><label> Звезд:  <select name="stars_rate">
                    <?
                   
                    for($i = 0; $i <= 5; $i++ )
                    {
                        ?>
                        <option value="<?echo $i;?>" <?if($i==$stars_rate) echo 'selected'?>><?echo $i.' *';?></option>
                        <?
                    }
                    ?>
                </select></label></p>

                <p><input name="save" type="submit" value="Сохранить"></p>
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
