<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

require_once('./Models/User.php');
require_once('MySQLUserManager.php');
require_once('phpassPasswordHasher.php');

User::set_password_hasher( new phpassPasswordHasher );
User::set_user_manager( new MySQLUserManager() );

//$u = new User("cherlton@gays.com","Cherlton","Milettes","passwords_suck");
//$u->save();

$users = User::get_user_by_first_name("Cherlton");

foreach($users as $user)
{
    $user->print_details();
}

//$u = User::get_user_by_id(16);
//
//echo $u->print_details();
//$res = $u->check_password("testpassword");
//echo (( $res === FALSE ) ? "Password comparison failed!\n": "Password comparison success!\n");
//$res = $u->check_password("testpass");
//echo (( $res === FALSE ) ? "Password comparison failed!\n": "Password comparison success!\n");
?>