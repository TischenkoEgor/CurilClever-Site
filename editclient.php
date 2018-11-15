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
            $cl_id = $_GET["id"];
            //1. подключаемся к серверу
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $link = mysqli_connect($host, $user, $password, $database) 
            or die("Ошибка " . mysqli_error($link));
            //2. создадим  запрос
            $query = "SELECT * FROM clients WHERE clients.id=".$cl_id;
            $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));     
            $result=mysqli_fetch_assoc($result);
            
            if(count($result))
            {
                $name = $result["first_name"];
                $second_name = $result["second_name"];
                $age = $result["age"];
                $sex = $result["sex"];
                $phone = $result["phone"];
                $email = $result["email"];
                $passport_data = $result["passport_data"];    
            }
            // закрываем подключение
            mysqli_close($link);

            $name_mes = "";
            $second_name_mes = "";
            $age_mes = "";
            $sex_mes = "";
            $phone_mes = "";
            $email_mes = "";
            $passport_data_mes = "";
        }
        $error_num = 0;
        $input_num = 0;

        if(isset($_POST['name'])){
            $input_num++;
            $name = $_POST['name'];
            if(strlen($name) <= 3)
            {
                $name_mes = "Длина имени не менее 3 символов!";
                $error_num ++;
            }
        }

        if(isset($_POST['lastname'])){
            $input_num++;
            $second_name = $_POST['lastname'];
            if(strlen($second_name) <= 3)
            {
                $second_name_mes = "Длина фамилии не менее 3 символов!";
                $error_num ++;
            }
        }
        
        if(isset($_POST['age']) )
        {
            $input_num++;
            $age = $_POST['age'];
            if (strlen($age) == 0 || !is_numeric($age)){
                $age_mes = "не число или не введен!";
                $error_num ++; 
            }
        }
        if(isset($_POST['sex']))
        {
            $input_num++;
            $sex = $_POST['sex'];
            if(strlen($sex) < 3){
                $sex_mes = "Не выбран пол!";
                $error_num ++; 
            }
            else
            {
                if($sex == "male")
                    $sex = 1;
                if($sex == "female")
                    $sex = 0;
            }

        }
        if(isset($_POST['passportdata']) )
        {
            $input_num++;
            $passport_data = $_POST['passportdata'];
            if ( strlen($passport_data) <= 9)
            {
                $passport_data_mes = "Слишком короткие паспортные данные";
                $error_num ++;    
            }
        }
        if(isset($_POST['email']))
        {
            $input_num++;
            $email = $_POST['email'];
            if(strlen($email) <= 3 )
            {
                $email_mes = "Длина почты не менее 3х символов!";
                $error_num ++;    
            }
        }
        if(isset($_POST['phone']))
        {
            $input_num++;
            $phone = $_POST['phone'];
            if(strlen($_POST['phone']) <= 3)
            {
                $phone_mes = "Длина телефона не менее 3х символов!";
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
            $query = "UPDATE clients SET first_name=?,second_name=?,age=?,sex=?,phone=?,email=?,passport_data=? WHERE id=?";

            //3. подготовим запрос       
            $stmt = mysqli_prepare($link, $query);  
            //4. вставим данные из формы 
            
            $stmt->bind_param("ssiisssi",$name, $second_name, $age, $sex, $phone, $email, $passport_data, $cl_id);
            $stmt->execute();
            echo_positive_msg("успеш6но обновлено, блеат!");
        }

        ?>
        <H2>Создать клиента</H2>
       
        <fieldset>
            <legend>Данные клиента</legend>
            <form action="editclient.php?id=<?echo $cl_id;?>" method="post" name="editclientform">
                <? echo_input_error($name_mes); ?>
                <p><label>имя:<input name="name" type="text" value="<? echo $name;?>"></label></p> 

                <? echo_input_error($second_name_mes); ?>
                <p><label>Фамилия: <input name="lastname" value="<? echo $second_name;?>" size="30" type="text"></label></p>

                <? echo_input_error($age_mes); ?>
                <p><label>Возраст:<input name="age" value="<? echo $age;?>" size="30" type="text"></label></p>

                <? echo_input_error($sex_mes); ?>
                <p>Пол:
                    <input name="sex" type="radio" value="male" <?if( $sex==1) echo 'checked';?>> муж
                    <input name="sex" type="radio" value="female"<?if( $sex==0) echo 'checked';?>> жен
                </p>

                <? echo_input_error($email_mes); ?>
                <p><label>email:<input name="email" value="<? echo $email;?>" size="30" type="email"></label></p>

                <? echo_input_error($phone_mes); ?>
                <p><label>телефон:<input name="phone" value="<? echo $phone;?>" size="30" type="phone"></label></p>

                <? echo_input_error($passport_data_mes); ?>
                <p><label>Паспортные данные: <input name="passportdata" value="<? echo $passport_data;?>" size="30" type="text" ></label></p>

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
