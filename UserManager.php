<?php

interface UserManager
{
    public function get_user_by_id($id);
    public function get_user_by_email($email);
    public function get_users_by_first_name($first_name);//, $offset, $limit);
    public function get_users_by_last_name($last_name);//, $offset, $limit);
    public function get_all();
    public function save(User $user_obj);   
}


?>