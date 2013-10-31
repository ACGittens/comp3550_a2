

<?php

require('UserManager.php');
require('config.inc.php');



class MySQLUserManager implements UserManager
{
    private $get_user_by_id_stmt;
    private $get_user_by_email_stmt;
    private $get_users_by_first_name_stmt;
    private $get_users_by_last_name_stmt;
    private $get_all_stmt;
    private $save_stmt;
    
    private $id;
    private $email;
    private $first_name;
    private $last_name;
    
    private $result_id;
    private $result_hash;
    private $result_email;
    private $result_first_name;
    private $result_last_name;    
    
    private $mysqli;
    
    public __construct()
    {
        global $CFG;
        $this->mysqli = new mysqli($CFG['location'],$CFG['username'],$CFG['password'],$CFG['database']);
        if ($mysqli->connect_errno)
        {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        
        
        
        $this->get_user_by_id_stmt = $this->mysqli->prepare("SELECT id,email,hash,first_name,last_name FROM users WHERE id=?");
        $this->get_user_by_id_stmt->bind_param("d",$this->id);
        
        $this->get_user_by_email_stmt = $this->mysqli->prepare("SELECT id,email,hash,first_name,last_name FROM users WHERE email=?");
        $this->get_user_by_email_stmt->bind_param("s",$this->email);
        
        $this->get_users_by_first_name_stmt = $this->mysqli->prepare("SELECT id,email,hash,first_name,last_name FROM users WHERE first_name=?");
        $this->get_users_by_first_name_stmt->bind_param("s",$this->first_name);
        
        $this->get_users_by_last_name_stmt = $this->mysqli->prepare("SELECT id,email,hash,first_name,last_name FROM users WHERE last_name=?");
        $this->get_users_by_last_name_stmt->bind_param("s",$this->last_name);
        
        $this->get_all = $mysqli->prepare("SELECT id,email,hash,first_name,last_name FROM users");
    }
    
    
    public function get_user_by_id($id)
    {
        $this->id = $id;
        
    }
    public function get_user_by_email($email);
    public function get_users_by_first_name($first_name, $offset, $limit);
    public function get_users_by_last_name($last_name, $offset, $limit);
    public function get_all();
    public function save(User $user_obj);   

}


?>