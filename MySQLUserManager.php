

<?php

require('UserManager.php');
require('config.inc.php');
require('./Models/User.php');


class MySQLUserManager implements UserManager
{
    private $get_user_by_id_stmt;
    private $get_user_by_email_stmt;
    private $get_users_by_first_name_stmt;
    private $get_users_by_last_name_stmt;
    private $get_all_stmt;
    private $save_stmt;
    
    //TO IMPLEMENT LATER
    //private $get_users_by_first_name_stmt_offset;
    //private $get_users_by_last_name_stmt_offset;
    //private $get_all_stmt_offset;
    
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
    
    public function __construct()
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
        
        $this->get_all_stmt = $mysqli->prepare("SELECT id,email,hash,first_name,last_name FROM users");
        
        $this->save_stmt = $mysqli_prepare("INSERT INTO users(id,email,hash,first_name,last_name) VALUES(?,?,?,?,?) ".
                                           "ON DUPLICATE KEY UPDATE email=VALUES(email),hash=VALUES(hash),".
                                           "first_name=VALUES(first_name),last_name=VALUES(last_name))");
        $this->save_stmt->bind_param("dssss",$this->id,$this->email,$this->hash,$this->first_name,$this->last_name);
        
        
        $stmts = array();
        $stmts[] = $this->get_user_by_id_stmt;
        $stmts[] = $this->get_user_by_email_stmt;
        $stmts[] = $this->get_user_by_first_name_stmt;
        $stmts[] = $this->get_user_by_last_name_stmt;
        $stmts[] = $this->get_all_stmt;
        
                                           
        foreach( $stmts as $stmt )
        {
               $stmt->bind_result($this->result_id,$this->result_email,$this->result_hash,$this->result_first_name,$this->result_last_name);
        }
    }
    
                                           
    private function create_users_from_stmt_results( $stmt )
    {
        $user_results = array();
        while( $stmt->fetch()  )
        {
            $new_user = User::_create_user( $this->result_id, $this->result_email, $this->result_hash,
                                           $this->result_first_name, $this->result_last_name);
            
            $user_results[] = $new_user;
        }
        return $user_results;
    }
    
    public function get_user_by_id($id)
    {
        $this->id = $id;
        $this->get_user_by_id_stmt->execute();
        $this->get_user_by_id_stmt->fetch();
        $new_user = User::create_user( $this->result_id, $this->result_email, $this->result_hash,
                                       $this->result_first_name, $this->result_last_name );
        return $new_user;
    
    }
                                       
                                       
    public function get_user_by_email($email)
    {
        $this->email = $email;
        $this->get_user_by_email_stmt->execute();
        //Each user should have a unique email so
        //fetching only once is fine.
        $this->get_user_by_email_stmt->fetch();
        $new_user = User::create_user( $this->result_id, $this->result_email, $this->result_hash,
                                      $this->result_first_name, $this->result_last_name);
        return $new_user;
    }
                                       
                                       
    public function get_users_by_first_name($first_name)
    {
        $this->first_name = $first_name;
        $this->get_users_by_first_name_stmt->execute();
        $user_results = create_users_from_stmt_results( $this->get_users_by_first_name_stmt );
        return $user_results;
    }
    
                                       
    
    public function get_users_by_last_name($last_name)
    {
        $this->last_name = $last_name;
        $this->get_users_by_last_name_stmt->execute();
        $user_results = create_users_from_stmt_results( $this->get_users_by_last_name_stmt );
        return $user_results;
    }
                             
                                           
    public function get_all()
    {
        $this->get_all_stmt->execute();
        $user_results = create_users_from_stmt_results( $this->get_all_stmt );
        return $user_results;
    }   
                                           
                                           
    public function save(User $user_obj)
    {
        $this->id = $user_obj->get_id();
        $this->email = $user_obj->get_email();
        $this->hash = $user_obj->get_hash();
        $this->first_name = $user->get_first_name();
        $this->last_name = $user->get_last_name();
        
        $this->save_stmt->execute();
    }
                                             
}
?>