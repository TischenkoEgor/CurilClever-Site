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
        <?
        $OrderName = "";
        $clientid = "";
        $hotelid = "";
        $date_arrival = "";
        $date_departure = "";

        $OrderName_mes = "";
        $clientid_mes = "";
        $hotelid_mes = "";
        $date_arrival_mes = "";
        $date_departure_mes = "";

        $error_num = 0;
        $input_num = 0;

        if(isset($_POST['OrderName'])){
            $input_num++;
            $OrderName = $_POST['OrderName'];
            if(strlen($OrderName) < 5)
            {
                $OrderName_mes = "слишком короткое название!";
                $error_num ++;
            }
        }

        if(isset($_POST['clientid'])){
            $input_num++;
            $clientid = $_POST['clientid'];
            if(!is_numeric($clientid))
            {
                $clientid_mes = "не выбран пользователь";
                $error_num ++;
            }
        }

        if(isset($_POST['hotelid']) )
        {
            $input_num++;
            $hotelid = $_POST['hotelid'];
            if (!is_numeric($hotelid)){
                $hotelid_mes = "не выбран отель";
                $error_num ++; 
            }
        }
        if(isset($_POST['date_arrival']) )
        {
            $input_num++;
            $date_arrival = $_POST['date_arrival'];
            if (!is_Date($date_arrival)){
                $date_arrival_mes = "некорректная дата!";
                $error_num ++; 
            }
        }
        if(isset($_POST['date_departure']))
        {
            $input_num++;
            $date_departure = $_POST['date_departure'];
            echo_warning_msg("date-dep: ".$date_departure);
            if(!is_Date($date_departure))
            {
                $date_departure_mes = "некорректная дата!";
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

            $query = "INSERT INTO orders SET OrderName=?,person_id=?,hotel_id=?,date_arrival=?,date_departure=?";
            echo_warning_msg($query2);

            //3. подготовим запрос       
            $stmt = mysqli_prepare($link, $query);  
            //4. вставим данные из формы 
            
            $stmt->bind_param("sssss",
                $OrderName, 
                $clientid, 
                $hotelid, 
                date("Y-m-d H:i:s", strtotime($date_arrival)), 
                date("Y-m-d H:i:s", strtotime($date_departure)));
           
            $stmt->execute();
            
            echo_positive_msg("успеш6но создано, блеат!");
            $js_redir = "<script type='text/javascript'>  
                            setTimeout(function () 
                            { 
                                window.location.href = 'orders.php.'; 
                             }, 2000);  
                        </script>";    

            echo $js_redir;
            exit();
        }
        ?>
        <div class="page">
            <H2>Создать заявку</H2>
                <fieldset>
                    <legend>Данные заявки</legend>
                    <?
                    if($error_num > 0)
                    {
                        echo_input_error("Не удалось создать заявку: некорректные параметры!");    
                    }
                    ?>
                    <form action="createorder.php" method="post" name="createorderform">

                    <? echo_input_error($OrderName_mes); ?>
                    <p><label> Название заявки: <input name="OrderName" type="text" value="<?echo $OrderName;?>"></label></p>
                    
                    <? echo_input_error($clientid_mes); ?>
                    <p><label> Клиент:  <select name="clientid" >
                        <?
                        // подключаемся к серверу
                        $link = mysqli_connect($host, $user, $password, $database) 
                        or die("Ошибка " . mysqli_error($link));

                        // заюираем всех клиентов из базы данных
                        $query ="SELECT * FROM clients";
                        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));  
                        while($person = mysqli_fetch_array($result))
                        {
                            ?>
                            <option  value="<?echo $person['id'];?>"  <?if($person['id'] == $clientid) echo "selected";?> ><?echo $person['first_name'].' '.$person['second_name'];?></option>
                            <? 
                        }
                        ?>
                    </select></label></p>
                    <? echo_input_error($hotelid_mes); ?>
                    <p><label> Отель:  <select name="hotelid">
                        <?
                        // подключаемся к серверу
                        $link = mysqli_connect($host, $user, $password, $database) 
                        or die("Ошибка " . mysqli_error($link));

                        // заюираем всех клиентов из базы данных
                        $query ="SELECT * FROM hotels";
                        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));  
                        while($hotel = mysqli_fetch_array($result))
                        {
                            ?>
                            <option value="<?echo $hotel['id'];?>" <?if($hotel['id'] == $hotelid) echo "selected";?>  ><?echo $hotel['name'].' '.$hotel['stars_rate'].' *';?></option>
                            <?
                        }
                        ?>
                    </select></label></p>

                    <? echo_input_error($date_arrival_mes); ?>
                    <p><label> Заселение: <input type="date" name="date_arrival" value="<?echo $date_arrival;?>"></label></p>

                    <? echo_input_error($date_departure_mes); ?>
                    <p><label> Выезд: <input type="date" name="date_departure" value="<?echo $date_departure;?>"></label></p>

                    <p><input name="save" type="submit" value="Создать заявку"></p>
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
