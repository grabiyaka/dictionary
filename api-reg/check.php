<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <base href="http://localhost/projects/en/">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php

$login = filter_var(trim( $_POST['login']), FILTER_SANITIZE_STRING); //фильтрация

$pass = filter_var(trim( $_POST['pass']), FILTER_SANITIZE_STRING);



if(mb_strlen($login) < 5 || mb_strlen($login) > 90) //mb_strlen($login) длина переменной
{
    echo "Недопустимая длина логина";
    exit();
}else if(mb_strlen($pass) < 6 || mb_strlen($pass) > 90)
{
    echo "Недопустимая длина пароля";
    exit();
}

$pass = md5($pass."dimaloh228aye");

$mysql = new mysqli("localhost", "root", "", "dictionary");

$count = $mysql->query(" SELECT * FROM users_acc WHERE `login` = '$login' ")->num_rows;


if($count){  
    echo "<br>";
    echo "Пользователь с таким логином уже есть!";
    echo "<br>";
    echo " <a href=''>Вернуться назад</a>";
    die();
}

$mysql->query("INSERT INTO `users_acc` (`login`, `pass`) VALUES('$login', '$pass')");

header('Location: /projects/en');
exit();

