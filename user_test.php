<?php

require('./Models/User.php');
require('MySQLUserManager.php');
require('phpassPasswordHasher.php');

User::set_password_hahser( new phpassPasswordHasher );
User::set_user_manager( new MySQLUserManager() );

$u = new User("rikaard1993@hotmail.com","rikaard","hosein","testpassword");
$u->save();

?>