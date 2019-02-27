<?
    session_start();
    $_SESSION = array(); //Очищаем сессию
    session_destroy(); //Уничтожаем
    // отправляем пользователя в ж.. на главную страницу
    ob_start();
    $new_url = 'index.php';
    header('Location: '.$new_url);
    ob_end_flush();
?>