<?php

require('PasswordHash.php');

class phpassPasswordHasher implements PasswordHasher
{
    public function hash_password( $password )
    {
        $t_hasher = new PasswordHash(8, FALSE);
        $hash = $t_hasher->HashPassword($password);
        return $hash;
    }
}

?>