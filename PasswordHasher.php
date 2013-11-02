<?php

interface PasswordHasher
{
    public function hash_password( $password );
    public function check_password( $password, $hash );
}


?>