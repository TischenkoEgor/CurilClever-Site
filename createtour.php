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
        $order_id = -1;
        $OrderName = "";
        $clientid = "";
        $hotelid = "";
        $date_arrival = "";
        $date_departure = "";




        if(isset($_GET["orderid"]))
        {
             
            $order_id = $_GET["orderid"];
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            //1. подключаемся к серверу
            $link = mysqli_connect($host, $user, $password, $database) 
            or die("Ошибка " . mysqli_error($link));
            //2. создадим  запрос
           
            $query ="SELECT 
                orders.orderid AS order_id,
                clients.first_name AS person_first_name, 
                clients.second_name AS person_second_name, 
                hotels.name AS hotel_name,
                hotels.id AS hot_id,
                orders.order_registration_date AS order_date,
                OrderName,
                date_arrival, 
                date_departure
                FROM orders
                    INNER JOIN clients 
                        ON person_id = clients.id
                    INNER JOIN hotels 
                        ON hotel_id = hotels.id
                WHERE 
                    orders.orderid=".$order_id; 


            $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));     
            $result = mysqli_fetch_assoc($result);

            if(count($result))
            {

                $OrderName = $result["OrderName"];
                $clientFIO =$result["person_first_name"].' '.$result["person_second_name"];
                $hotelid = $result["hot_id"];
                $date_arrival = date("Y-m-d", strtotime($result["date_arrival"]));
                $date_departure = date("Y-m-d", strtotime($result["date_departure"]));   
            }
        }    


        $OrderName_mes = "";
        $hotelid_mes = "";
        $date_arrival_mes = "";
        $date_departure_mes = "";

        $error_num = 0;
        $input_num = 0;

       

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
            if(!is_Date($date_arrival))
            {
                $date_departure_mes = "некорректная дата!";
                $error_num ++;    
            }
        }
        
        if(isset($_POST['save']))
        {
            // Обновление записи в базе
            if($error_num == 0 && $input_num > 0)
            {
                //1. подключаемся к серверу
                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                $link = mysqli_connect($host, $user, $password, $database) 
                or die("Ошибка " . mysqli_error($link));
                //2. создадим  запрос

                $query = 
                    "UPDATE 
                        orders 
                    SET 
                        hotel_id=?,date_arrival=?,date_departure=? 
                    WHERE 
                        orderid=?";
                echo_warning_msg($query2);

                //3. подготовим запрос       
                $stmt = mysqli_prepare($link, $query);  

                //4. вставим данные из формы 
                $stmt->bind_param("issi", 
                    $hotelid, 
                    date("Y-m-d H:i:s", strtotime($date_arrival)), 
                    date('Y-m-d H:i:s', strtotime($date_departure)), 
                    $order_id);

                $stmt->execute();
                echo_positive_msg("успешно обвнолено, блеат!");

            }
        }

        if(isset($_POST['remove']))
        {
            // Удаление записи в базе
            if($error_num == 0 && $input_num > 0)
            {
            //1. подключаемся к серверу
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $link = mysqli_connect($host, $user, $password, $database) 
            or die("Ошибка " . mysqli_error($link));
            //2. создадим  запрос

            $query = 
                "DELETE FROM
                    orders 
                WHERE 
                    orderid=?";

            //3. подготовим запрос       
            $stmt = mysqli_prepare($link, $query);  

            //4. вставим данные из формы 
            $stmt->bind_param("i", $order_id);

            $stmt->execute();
            echo_positive_msg("успешно удалено, блеат!");
            $js_redir = "<script type='text/javascript'>  
                            setTimeout(function () 
                            { 
                                window.location.href = 'orders.php.'; 
                            }, 2000);  
                        </script>";    

            echo $js_redir;
            exit();

            }
        }
        ?>
        <div class="page">
            <H2>Создание тура из заявки</H2>
                <fieldset>
                    <legend>Данные тура</legend>
                    <?
                    if($error_num > 0)
                    {
                        echo_input_error("Не удалось создать заявку: некорректные параметры!");    
                    }
                    ?>
                    <form action="controlorder.php?id=<?echo $order_id?>" method="post" name="editorderform">

                    <p><label> Название заявки: <input name="OrderName" type="text" value="<?echo $OrderName;?>" disabled></label></p>
                    
                    <p><label> Клиент:  <input name="clientFIO" type="text" value="<?echo $clientFIO;?>" disabled></label></p>

                    <? echo_input_error($hotelid_mes); ?>
                    <p><label> Отель:  <select name="hotelid" disabled>
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
                    <p><label> Заселение: <input type="date" name="date_arrival" value="<?echo $date_arrival;?>" disabled></label></p>

                    <? echo_input_error($date_departure_mes); ?>
                    <p><label> Выезд: <input type="date" name="date_departure" value="<?echo $date_departure;?>" disabled></label></p>
                    <p><label> Полная стоимость: <input type="number" name="price" value="<?echo $price;?>"> руб.</label></p>

                    <p><label> Статус оплаты:  
                        <select name="hotelid">
                            <option value="0">не оплачено</option>
                            <option value="1">внесена предоплата</option>
                            <option value="2">100% оплачено</option>
                        </select>
                    </label></p>                    


                    <p><label>Комментарий к туру</label></p>
                    <p>
                        <textarea name="comment" value="<?echo $comment;?>" rows="7" cols="46"> </textarea></p>      
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
