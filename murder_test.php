<?php

require_once('./Models/Murder.php');
require_once('MySQLMurderManager.php');


$m = new Murder('jarred',20,'flatland','knife','multiple stab wounds');
$m->save();


?>
