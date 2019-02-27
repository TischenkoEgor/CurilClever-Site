<? 
    // если не получается получить id сессии (это значит что сессия не открыта) - открываем сессию
    if (!session_id())
        session_start();
    require 'config.php';
    require 'functions.php';

// если пользователь авторизован, ничего не делаем
// если нет, идет нахуй (авторизовывааться)

if(isset($_SESSION['userid']))    
{
    // ничего не делаем
}
else
{
    // отправляем нахер логиниться
    ob_start();
    $new_url = 'login.php';
    header('Location: '.$new_url);
    ob_end_flush();
}
?>