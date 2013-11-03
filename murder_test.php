<?php

require_once('./Models/Murder.php');
require_once('MySQLMurderManager.php');


Murder::set_murder_manager( new MySQLMurderManager );

// $m = new Murder('jarred',20,'flatland','knife','multiple stab wounds');
// $m->save();


$murder_results = Murder::get_murders_by_name("%j%");
foreach( $murder_results as $res )
{
	echo $res->get_details()."\n";
}

?>
