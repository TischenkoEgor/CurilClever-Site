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
        if(isset($_GET['create']))
            $createMode = 1;

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
             
            $tour_id = $_GET["tourid"];
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
                clients.id AS clientid,
                tours.name AS name,
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
                        tours.id=".$tour_id; 


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
        
        if(isset($_POST['tourname'])){
            $input_num++;
            $tourname = $_POST['tourname'];
            if(strlen($tourname) == 0)
            {
                $clientid_mes = "название не может быть пустым";
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


        // создание нового тура в базе
        if(isset($_POST['create_tour']) && $error_num == 0)
        {
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
            $stmt->bind_param("siisssii",
                $tourname, 
                $clientid, 
                $hotelid, 
                date("Y-m-d H:i:s", strtotime($date_arrival)), 
                date("Y-m-d H:i:s", strtotime($date_departure)),
                $comment,
                $price,
                $pay_status);
        
            $stmt->execute();
            echo_positive_msg("успеш6но создано, брат!");


            $tour_id = mysqli_insert_id($link);
            $js_redir = "<script type='text/javascript'>  
                            setTimeout(function () 
                            { 
                                window.location.href = 'edittour.php?tourid=".$tour_id."'; 
                            }, 2000);  
                        </script>";    

            echo $js_redir;    
            exit();                    
        }

        // сохранение изменений параметров тура
        if(isset($_POST['save_tour']) && $error_num == 0)
        {
            //1. подключаемся к серверу
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $link = mysqli_connect($host, $user, $password, $database) 
            or die("Ошибка " . mysqli_error($link));
            //2. создадим  запрос

            $query = 
            "UPDATE  
                    tours 
                SET 
                    name=?,
                    client_id=?,
                    hotel_id=?,
                    begin_date=?,
                    end_date=?,
                    comment=?,
                    price=?,
                    pay_status=?
            WHERE
                id=?";
                 
            //3. подготовим запрос       
            $stmt = mysqli_prepare($link, $query);  
           
            //4. вставим данные из формы 
            $stmt->bind_param("siisssiii",
                $tourname, 
                $clientid, 
                $hotelid, 
                date("Y-m-d H:i:s", strtotime($date_arrival)), 
                date("Y-m-d H:i:s", strtotime($date_departure)),
                $comment,
                $price,
                $pay_status,
                $tour_id);
         
            $stmt->execute();
            echo_positive_msg("тур успешно обновлен, бро!");
        }

        // удалеие тура из базы
        if(isset($_POST['delete_tour']))
        {
             //1. подключаемся к серверу
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $link = mysqli_connect($host, $user, $password, $database) 
            or die("Ошибка " . mysqli_error($link));
            //2. создадим  запрос

            $query = 
            "DELETE 
                FROM 
                    tours
                WHERE
                    id=?";
                
            //3. подготовим запрос       
            $stmt = mysqli_prepare($link, $query);  

            //4. вставим данные из формы 
            $stmt->bind_param("i",$tour_id);
        
            $stmt->execute();
            echo_positive_msg("тур успешно удален!");

            $js_redir = "<script type='text/javascript'>  
                            setTimeout(function () 
                            { 
                                window.location.href = 'tours.php'; 
                            }, 2000);  
                        </script>";    

            echo $js_redir;    
            exit();                    
        }

        ?>
        <div class="page">

            <?
                if(!$createMode)
                {
                    ?>
                        <h2>Управление туром</h2>
                        <fieldset>
                            <legend>Внимание, операции необратимы!</legend>
                            <form action="edittour.php?<?if($tour_id > 0)echo 'tourid='.$tour_id;?><?if($createMode > 0)echo '&create=1';?>" method="post" name="controltourform">
                                <p><input type="submit" name='_tour' value="еще кнопка" disabled></p>
                                                               
                                <p><input type="submit" name='delete_tour' value="удалить тур"></p>
                            </form>


                        </fieldset>
                    <?
                }
            ?>

            <H2>
            <?
            if($createMode)
                echo 'Создание тура';
            else
                echo 'Изменение тура';
            ?>
            
            </H2>
            <fieldset>
                <legend>Данные тура</legend>
                <?
                if($error_num > 0)
                {
                    echo_input_error("Не удалось созлать тур: некорректные параметры!");    
                } 
                ?>
                <form action="edittour.php?<?if($tour_id > 0)echo 'tourid='.$tour_id;?><?if($createMode > 0)echo '&create=1';?>" method="post" name="configuretourform">


                    <?
                        //вывод скрытых полей - дублеров для disabled полей

                        if(!$createMode)
                        {
                            ?>
                                <input name="tourname" type="hidden" value="<?echo $tourname;?>">
                                <input name="clientid" type="hidden" value="<?echo $clientid;?>">
                            <?
                        }
                        
                    
                    ?>


                    <p><label> Название тура: <input name="<?if($createMode) echo 'tourname'?>" type="text" value="<?echo $tourname;?>" <?if(!$createMode) echo 'disabled';?>></label></p>
                    
                    <? echo_input_error($clientid_mes); ?>
                    <p><label> Клиент:  <select name="<?if($createMode) echo 'clientid'?>" <?if(!$createMode) echo 'disabled';?>>
                        <?
                        // подключаемся к серверу
                        $link = mysqli_connect($host, $user, $password, $database) 
                        or die("Ошибка " . mysqli_error($link));

                        // забираем всех клиентов из базы данных
                        $query ="SELECT * FROM clients";
                        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));  
                        while($person = mysqli_fetch_array($result))
                        {
                            ?>
                            <option  value="<?echo $person['id'];?>" <?if($person['id'] == $clientid) echo "selected";?> ><?echo $person['first_name'].' '.$person['second_name'];?></option>
                            <? 
                        }
                        ?>
                    </select></label></p>

                   
                    
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
                        </select>
                    </label></p>
                    
                    <p><?echo_input_error($begin_date)?></p>
                    <p><label> Заселение: <input type="date" name="date_arrival" value="<?echo $date_arrival;?>"></label></p>
                    
                    <p><?echo_input_error($end_date)?></p>
                    <p><label> Выезд: <input type="date" name="date_departure" value="<?echo $date_departure;?>"></label></p>
                    
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
                    <p><textarea name="comment" rows="7" cols="46"><?echo $comment;?> </textarea></p>      
                    
                    <?
                    if($createMode)
                    {
                    ?>
                        <p><input name="create_tour" type="submit"  value="создать тур"></p>
                    <?       
                    }
                    else
                    {
                    ?>
                        <p><input name="save_tour" type="submit"  value="сохранить тур"></p>
                    <?
                    }
                    ?>
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
