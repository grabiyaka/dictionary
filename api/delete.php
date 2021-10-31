<?php 

require "core.php";

post_check();

$db->q("DELETE FROM users_dictionary WHERE id='$id'  ");