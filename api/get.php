<?php

require "core.php";

post_check();

$user_id = $_COOKIE["id"];

echo $db->q(" SELECT * FROM users_dictionary WHERE `user_id` = '$user_id' ")->json();