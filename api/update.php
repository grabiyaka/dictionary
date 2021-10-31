<?php

require "core.php";

post_check();

$db->q(" UPDATE users_dictionary SET $input = '$value' WHERE id='$id' ");