<?php


require_once('PasswordHasher.php');
require_once('PasswordHash.php');

class phpassPasswordHasher implements PasswordHasher
{
    public function hash_password( $password )
    {
        $t_hasher = new PasswordHash(8, FALSE);
        $hash = $t_hasher->HashPassword($password);
        return $hash;
    }
    
    public function check_password( $password, $hash )
    {
        $t_hasher = new PasswordHash(8,FALSE);
        $res = $t_hasher->CheckPassword($password,$hash);
        return $res;
    }
}

?>