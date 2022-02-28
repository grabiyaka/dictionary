<?php

$login = filter_var(trim( $_POST['login']), FILTER_SANITIZE_STRING); //фильтрация

$pass = filter_var(trim( $_POST['pass']), FILTER_SANITIZE_STRING);

$pass = md5($pass."dimaloh228aye");

$mysql = new mysqli("localhost", "root", "", "dictionary");


$result = $mysql->query("SELECT * FROM `users_acc` WHERE `login` = '$login' AND `pass` = '$pass' ");
$user = $result->fetch_assoc();
if(!$user){
    echo "Неверный логин или пароль :(  ";
    echo " <a href='http://localhost/projects/en/'>Вернуться назад</a>";
    exit();
}

setcookie('user', $user['login'], time() + 3600 * 3600, "/projects/en/");
setcookie('id', $user["id"], time() + 3600 * 3600, "/projects/en/");


$mysql->close();

header('Location: /projects/en/');