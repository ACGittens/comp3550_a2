<?php

define("INVALID_ID",-1);

class User
{
    private $id;
    private $email;
    private $first_name;
    private $last_name;
    private $hash;
    
    static $user_manager;
    static $password_hasher;
    
    function __construct($email, $first_name, $last_name, $password)
    {
        $this->set_email($email);
        $this->set_first_name($first_name);
        $this->set_last_name($last_name);
        $this->set_password($password);
    }
    
    static function set_password_hasher( PasswordHasher $hasher )
    {
        User::$password_hasher = $hasher;
    }
    
    static function set_user_manager( UserManager $user_manager )
    {
        User::$user_manager = $user_manager;
    }
    
    function get_id()
    {
        return $this->id;
    }        
    
    function get_email()
    {
        return $this->email;
    }
    
    function get_first_name()
    {
        return $this->first_name;
    }
    
    function get_last_name()
    {
        return $this->last_name;
    }
    
    function get_hash()
    {
        return $this->hash;
    }
    
    private function set_id( $id )
    {
        $this->id = $id;
    }
    
    function set_email( $email )
    {
        $this->email = $email;
    }
    
    function set_first_name( $first_name )
    {
        $this->first_name = $first_name;
    }
    
    function set_last_name( $last_name )
    {
        $this->last_name = $last_name;
    }
    
    function set_password( $password )
    {
        $this->hash = User::$password_hasher->hash_password($password);
    }
    
    static function create_user($email, $first_name, $last_name, $password)
    {
        $new_user = new User($email,$first_name,$last_name,$password);
        $new_user->set_id( INVALID_ID );
        return $new_user;
    }
    
   
    static function get_user_by_id( $id )
    {
        $user = User::$user_manager->get_user_by_id( $id );
        return $user;
    }
    
    
    static function get_user_by_email($email)
    {
        $user = User::$user_manager->get_user_by_email( $email );
        return $user;
    }
    
    static function get_users_by_first_name($first_name, $offset, $limit)
    {
        $users = User::$user_manager->get_users_by_first_name( $first_name );
        return $users;
    }
    
    static function get_users_by_last_name($last_name, $offset, $limit)
    {
        $users = User::$user_manager->get_users_by_last_name( $last_name );
        return $users;
    }
    
    static function get_all()
    {
        $users = User::$user_manager->get_all();
        return $users;
    }
    
    /*
    This function is responsible for updating the database once a 
    new user has been created or modifications have been made to an existing user.
    */
    function save()
    {
        User::$user_manager->save( $this );
    }
}

?>