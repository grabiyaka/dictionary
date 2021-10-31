<?php

require "core.php";

post_check();

$user_id = $_COOKIE["id"];

echo $db->q(" SELECT * FROM users_dictionary WHERE `user_id` = '$user_id' ")->json();

if($e == 1){
    if($rating != 5){
        $db->q(" UPDATE users_dictionary SET rating = rating + 1 WHERE id='$id' ");
    }
}else{
    if($rating != 1){
        $db->q(" UPDATE users_dictionary SET rating = rating - 1 WHERE id='$id' ");
    }
}
