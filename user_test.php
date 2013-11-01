<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

require_once('./Models/User.php');
require_once('MySQLUserManager.php');
require_once('phpassPasswordHasher.php');

User::set_password_hasher( new phpassPasswordHasher );
User::set_user_manager( new MySQLUserManager() );

$u = new User("rikaard1993@hotmail.com","rikaard","hosein","testpassword");
$u->save();

?>