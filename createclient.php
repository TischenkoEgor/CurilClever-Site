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
            if(
                isset($_POST['name']) && strlen($_POST['name']) > 3 &&
                isset($_POST['lastname']) && strlen($_POST['lastname']) > 3 &&
                isset($_POST['age']) && strlen($_POST['age']) > 0 && is_numeric($_POST['age']) &&
                isset($_POST['sex']) && strlen($_POST['sex']) > 3 &&
                isset($_POST['email']) && strlen($_POST['email']) > 3 &&
                isset($_POST['passportdata']) && strlen($_POST['passportdata']) > 3 &&
                isset($_POST['phone']) && strlen($_POST['phone']) > 3)
            {
                echo ("<p style='color:green'> Все данные введены верно!!</p> ");
                // добавление в базу
               
                //1. подключаемся к серверу
                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
				$link = mysqli_connect($host, $user, $password, $database) 
                or die("Ошибка " . mysqli_error($link));
                //2. создадим шаблон запроса
                $sql = "INSERT INTO clients ( first_name, second_name, age, sex, phone, email, passport_data)
                        VALUES (?,?,?,?,?,?,?);";
                //3. подготовим запрос       
                $stmt = mysqli_prepare($link, $sql);  
                //4. вставим данные из формы 
                if($_POST['sex'] == "male") $sex = 1;
                if($_POST['sex'] == "female") $sex = 0;

                $stmt->bind_param("ssiisss",$_POST['name'], $_POST['lastname'], $_POST['age'], $sex, $_POST['phone'], $_POST['email'],$_POST['passportdata']);
                $stmt->execute();
                echo ("<p style='color:green'> Все данные добавлены верно!!</p> ");    
            }
            
            else if(
                isset($_POST['name']) ||
                isset($_POST['lastname']) || 
                isset($_POST['age']) || 
                isset($_POST['sex']) ||
                isset($_POST['email']) ||
                isset($_POST['phone']))
            {
                echo ("<p style='color:red'> ошибка ввода данных!!</p> ");
            }


        ?>


        <H2>Создать клиента</H2>
        <fieldset>
            <legend>Данные клиента</legend>
            <form action="createclient.php" method="post" name="createclientform">

                <p><label>имя:<input name="name" type="text" <? if (isset($_POST['name']))
                echo "value=\"".$_POST['name']."\"";?>></label></p> 
                <p><label>Фамилия: <input name="lastname" size="30" type="text" <?if( isset($_POST['lastname'])) echo "value=\"".$_POST['lastname']."\""; ?>></label></p>
                <?if(isset($_POST['age']) && strlen($_POST['age']) > 0 && !is_numeric($_POST['age']))
                    echo "<p style='color:red'> возраст это число!!</p>"; ?>
                <p><label>Возраст:<input name="age" size="30" type="text" <? if(isset($_POST['age'])) echo "value=\"".$_POST['age']."\""; ?>></label></p>
                
                <p>Пол:
                    <input name="sex" type="radio" value="male" <?if(isset($_POST['sex']) && $_POST['sex']=="male") echo "checked";?>> муж
                    <input name="sex" type="radio" value="female" <?if(isset($_POST['sex']) && $_POST['sex']=="female") echo "checked";?>> жен</p>
               
                <p><label>email:<input name="email" size="30" type="email" <? if (isset($_POST['email'])) echo "value=\"".$_POST['email']."\""; ?>></label></p>
               
                <p><label>телефон:<input name="phone" size="30" type="phone" <? if (isset($_POST['phone'])) echo "value=\"".$_POST['phone']."\""; ?>></label></p>
              
                <p><label>Паспортные данные: <input name="passportdata" size="30" type="text" <?if( isset($_POST['passportdata'])) echo "value=\"".$_POST['passportdata']."\""; ?>></label></p>
                
                <p><input name="register" type="submit" value="Создать"></p>
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
