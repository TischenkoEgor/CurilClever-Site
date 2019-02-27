<?php

if(isset($_POST['submit']))
{
    $to = "Nightmare218@yandex.ru";
    $first_name = $_POST['first_name'];
    $email = $_POST['email']; 
    $phone = $_POST['phone']; 
    $message = $_POST['message'];
    $subject = "отчет!";
    $message = 'Здравствуйте!  Cообщение было отправлено с  сайта Тищенко Е.М.'
	."\r\n".'имя отправителя: '.$first_name
    ."\r\n".'e-mail: '.$email
    ."\r\n".'номер телефона: '.$phone
    ."\r\n".'текст сообщения: '.$message;  
    $headers1 = 'from: '.$email;

    if(mail($to,$subject,$message,$headers1.'content-type: text/plain; charset=utf-8'))
    {
        echo 'попытка успешна<br>';
    }
    else
    {
        echo 'попытка не успешна<br>';
    }

    echo "сообщение отправлено. <br>спасибо вам ". $first_name . ", Big brother watches you.";
    echo "<br /><br /><a href='index.html'>вернуться на сайт.</a>";
}
    




?>