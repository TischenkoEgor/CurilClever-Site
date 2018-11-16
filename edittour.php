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
        // edittour.php?tourid=%&create=%
        // если флаг create=1 включаем все поля для редактирования
        // если  

        $createMode = 0;

        $tour_id = -1;
        $tourname = "";
        $clientid = "";
        $hotelid = "";
        $date_arrival = "";
        $date_departure = "";
        
        $price = "";
        $pay_status = "";
        $comment = ""; 

        // Если режим редактирования
        if(isset($_GET["tourid"]))
        {
             
            $tour_id = $_GET["orderid"];
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            //1. подключаемся к серверу
            $link = mysqli_connect($host, $user, $password, $database) 
            or die("Ошибка " . mysqli_error($link));
            //2. создадим  запрос
           
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
            INNER JOIN clients ON client_id = clients.id
            INNER JOIN hotels ON hotel_id = hotels.id
                    WHERE 
                        orders.orderid=".$order_id; 


            $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));     
            $result = mysqli_fetch_assoc($result);

            if(count($result))
            {
                $tour_id = $result["id"];
                $tourname = $result["name"];
                $clientid = $result["clientid"];
                $hotelid = $result["hotel_id"];
                $date_arrival =  date("Y-m-d", strtotime($result["begin_date"]));
                $date_departure = date("Y-m-d", strtotime($result["end_date"]));
                
                $price = $result["price"];
                $pay_status = $result["pay_status"];
                $comment = $result["comment"]; 
            }
            else
            {
                echo_input_error("Некорректная ссылка!");
                exit();
            }
        }    


        $tourname_mes = "";
        $hotelid_mes = "";
        $date_arrival_mes = "";
        $date_departure_mes = "";


        $price_mes = "";
        $pay_status_mes = "";
        $comment_mes = ""; 

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


        if(isset($_POST['price'])){
            $input_num++;
            $price = $_POST['price'];
            if(!is_numeric($price) || $price < 0)
            {
                $price_mes = "некорректная сумма";
                $error_num ++;
            }
        }

        if(isset($_POST['pay_status']) )
        {
            $input_num++;
            $pay_status = $_POST['pay_status'];
            if (!is_numeric($pay_status) || $pay_status < 0 || $pay_status > 2){
                $pay_status_mes = "некорректный статус оплаты";
                $error_num ++; 
            }
        }

        if(isset($_POST['comment']) )
        {
            $input_num++;
            $comment = $_POST['comment'];
        }

        if(isset($_POST['create_tour']) && $error_num == 0)
        {
            echo_warning_msg("попытка сохранения: сохранение в базу еще не работает");
             //1. подключаемся к серверу
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $link = mysqli_connect($host, $user, $password, $database) 
            or die("Ошибка " . mysqli_error($link));
            //2. создадим  запрос

            $query = 
            "INSERT 
                INTO 
                    tours 
                SET 
                    name=?,
                    client_id=?,
                    hotel_id=?,
                    begin_date=?,
                    end_date=?,
                    comment=?,
                    price=?,
                    pay_status=?";
                
            //3. подготовим запрос       
            $stmt = mysqli_prepare($link, $query);  

            //4. вставим данные из формы 
            $stmt->bind_param("ssssssii",
                $OrderName, 
                $clientid, 
                $hotelid, 
                date("Y-m-d H:i:s", strtotime($date_arrival)), 
                date("Y-m-d H:i:s", strtotime($date_departure)),
                $comment,
                $price,
                $pay_status);
        
            $stmt->execute();
            echo_positive_msg("успеш6но создано, брат!");
            // 2. Тело запроса на удаление заявки после создания тура
            $query = 
            "DELETE FROM
                orders 
            WHERE 
                orderid=?";

            //3. подготовим запрос       
            $stmt = mysqli_prepare($link, $query);  

            //4. вставим нмоер заявки
            $stmt->bind_param("i", $order_id);

            $stmt->execute();
            echo_positive_msg("успешно удалена заявка, блеат!");
           
            

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
            <H2>Создание тура из заявки</H2>
            <fieldset>
                <legend>Данные тура</legend>
                <?
                if($error_num > 0)
                {
                    echo_input_error("Не удалось созлать тур: некорректные параметры!");    
                } 
                ?>
                <form action="createtour.php?orderid=<?echo $order_id?>" method="post" name="configuretourform">

                    <p><label> Название заявки: <input name="OrderName" type="text" value="<?echo $OrderName;?>" disabled></label></p>
                    
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
                        </select>
                    </label></p>
                    



                    <p><?echo_input_error($begin_date)?></p>
                    <p><label> Заселение: <input type="date" name="date_arrival" value="<?echo $date_arrival;?>" disabled></label></p>
                    
                    <p><?echo_input_error($end_date)?></p>
                    <p><label> Выезд: <input type="date" name="date_departure" value="<?echo $date_departure;?>" disabled></label></p>
                    
                    <p><?echo_input_error($price_mes)?></p>
                    <p><label> Полная стоимость: <input type="number" name="price" value="<?echo $price;?>"> руб.</label></p>
                    
                    <p><?echo_input_error($pay_status_mes)?></p>
                    <p><label> Статус оплаты:  
                        <select name="pay_status">
                            <option value="0" <? if($pay_status == 0) echo 'selected'; ?> >не оплачено</option>
                            <option value="1" <? if($pay_status == 1) echo 'selected'; ?> >внесена предоплата</option>
                            <option value="2" <? if($pay_status == 2) echo 'selected'; ?> >100% оплачено</option>
                        </select>
                    </label></p>                    

                    <p><label>Комментарий к туру</label></p>
                    <p><textarea name="comment" value="<?echo $comment;?>" rows="7" cols="46"> </textarea></p>      

                    <p><input name="create_tour" type="submit" value="Зарегистрировать тур"></p>
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
