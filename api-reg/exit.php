<?php

setcookie('user', $user['name'], time() - 3600, "/projects/en/");
setcookie('id', $user['id'], time() - 3600, "/projects/en/");
header('Location: /projects/en/');