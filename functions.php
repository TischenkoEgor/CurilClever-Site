<?
function echo_input_error($msg)
{
    if(strlen($msg) > 0)
    {
        ?><p style='color:red;'><? echo $msg; ?> </p><?
    }
}
function echo_positive_msg($msg)
{
    if(strlen($msg) > 0)
    {
        ?><p style='color:green;'><? echo $msg; ?> </p><?
    }
}
function echo_warning_msg($msg)
{
    if(strlen($msg) > 0)
    {
        ?><p style='color:orange;'><? echo $msg; ?> </p><?
    }
}
function is_Date($str){
    return is_numeric(strtotime($str));
}
// экранизация SQL инъекций
function quote($var){
    return mysql_escape_string($var);
}
?>