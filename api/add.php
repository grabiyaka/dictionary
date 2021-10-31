<?php

require "core.php";

post_check();

$user_id = $_COOKIE["id"];

$db->q("INSERT into users_dictionary SET en='$en', ru='$ru', user_id='$user_id', phrase='$phrase', rating=1 ");

echo to_json([
    "en"=> $en,
    "ru" => $ru,
    "phrase"=> $phrase,
    "rating"=> 1,
]);