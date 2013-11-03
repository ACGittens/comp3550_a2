<?php

require_once('config.inc.php');
require_once('MurderManager.php');
require_once('./Models/Murder.php');

class MySQLMurderManager implements MurderManager
{
	private $get_murder_by_id_stmt;
	private $get_murders_by_name_stmt;
	private $get_murders_by_age_stmt;
	private $get_murders_by_address_stmt;
	private $get_murders_by_cause_stmt;
	private $get_murders_by_comment_stmt;

	private $id;
	private $name;
	private $age;
	private $address;
	private $cause;
	private $comment;

	private $rid;
	private $rname;
	private $rage;
	private $raddress;
	private $rcause;
	private $rcomment;

	private $mysqli;

    $columns = " id,name,age,address,cause,comment ";
    $table = " crime ";

	public function __construct()
	{
		global $CFG;
		$this->mysqli = new mysqli($CFG['location'],$CFG['username'],$CFG['password'],$CFG['database']);
        if ($this->mysqli->connect_errno)
        {
            echo "Failed to connect to MySQL: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error;
        }

        $this->get_murder_by_id_stmt = $this->mysqli->prepare("SELECT".$this->columns."FROM".$table."WHERE id=?");
        $this->get_murder_by_id_stmt->bind_param("d",$this->id);

        $this->get_murder_by_name_stmt = $this->mysqli->prepare("SELECT".$this->columns."FROM".$table."WHERE name=?");
        $this->get_murder_by_name_stmt->bind_param("s",$this->name);

        $this->get_murder_by_age_stmt = $this->mysqli->prepare("SELECT".$this->columns."FROM".$table."WHERE age=?");
        $this->get_murder_by_age_stmt->bind_param("d",$this->age);
        
        $this->get_murder_by_address_stmt = $this->mysqli->prepare("SELECT".$this->columns."FROM".$table."WHERE address=?");
        $this->get_murder_by_address_stmt->bind_param("s",$this->address);
        
        $this->get_murder_by_cause_stmt = $this->mysqli->prepare("SELECT".$this->columns."FROM".$table."WHERE cause=?");
        $this->get_murder_by_cause_stmt->bind_param("s",$this->cause);
        
        $this->get_murder_by_comment_stmt = $this->mysqli->prepare("SELECT".$this->columns."FROM".$table."WHERE comment=?");
        $this->get_murder_by_comment_stmt->bind_param("s",$this->comment);

        $this->get_all_stmt = $this->mysqli->prepare("SELECT".$this->columns."FROM".$table);

		$this->save_stmt = $this->mysqli->prepare("INSERT INTO crim(".$this->columns.") VALUES(?,?,?,?,?,?) ".
		                           "ON DUPLICATE KEY UPDATE name=VALUES(name),age=VALUES(age),".
		                           "address=VALUES(address),cause=VALUES(cause),comment=VALUES(comment)");

		$this->save_stmt->bind_param("dsdsss",$this->id,$this->name,$this->age,$this->address,$this->cause,$this->comment);

		$stmts = array();
		$stmts[] = $this->get_murder_by_id_stmt;
		$stmts[] = $this->get_murder_by_name_stmt;
		$stmts[] = $this->get_murder_by_age_stmt;
		$stmts[] = $this->get_murder_by_address_stmt;
		$stmts[] = $this->get_murder_by_cause_stmt;
		$stmts[] = $this->get_murder_by_comment_stmt;
		$stmts[] = $this->get_all_stmt;
        
        foreach( $stmts as $stmt )
        {    
               $stmt->bind_result($this->rid,$this->rname,$this->rage,$this->raddress,$this->rcause,$this->rcomment);
        }

	}


	private function create_murders_from_stmt_results( $stmt )
	{
		$murder_results = array();
        while( $stmt->fetch()  )
        {
            $new_murder = Murder::_create_murder( $this->rd, $this->rname, $this->rage,
                                           $this->raddress, $this->rcause, $this->rcomment);
            
            $murder_results[] = $new_murder;
        }
        return $murder_results;
	}



	public function get_murder_by_id( $id )
	{
		$this->id = $id;
		$this->get_murder_by_id_stmt->execute();
		$this->get_murder_by_id->fetch();
		$new_murder = Murder::_create_murder($this->rid,$this->rname,$this->rage,$this->raddress,$this->rcause,$this->rcomment);
		return $new_murder;
	}


	public function get_murders_by_name( $name )
	{
		$this->name = $name;
		$this->get_murder_by_name_stmt->execute();
		$murder_results = $this->create_murders_from_stmt_results( $this->get_murder_by_name_stmt );
		return $murder_results;
	}

	public function get_murders_by_age( $age )
	{
		$this->age = $age;
		$this->get_murder_by_age_stmt->execute();
		$murder_results = $this->create_murders_from_stmt_results( $this->get_murder_by_age_stmt );
		return $murder_results;
	}


	public function get_murders_by_address( $address )
	{
		$this->address = $address;
		$this->get_murder_by_address_stmt->execute();
		$murder_results = $this->create_murders_from_stmt_results( $this->get_murder_by_address_stmt );
		return $murder_results;
	}

	public function get_murders_by_cause( $cause )
	{
		$this->cause = $cause;
		$this->get_murder_by_cause_stmt->execute();
		$murder_results = $this->create_murders_from_stmt_results( $this->get_murder_by_cause_stmt );
		return $murder_results;
	}

	public function get_murders_by_comment( $comment )
	{
		$this->comment = $comment;
		$this->get_murder_by_comment_stmt->execute();
		$murder_results = $this->create_murders_from_stmt_results( $this->get_murder_by_comment_stmt );
		return $murder_results;
	}

	public function get_all()
	{
		$this->get_all_stmt->execute();
		$murder_results = $this->create_murders_from_stmt_results($this->get_all_stmt);
		return $murder_results;
	}



	public function save(Murder $m)
	{
		$this->id = $m->get_id();
		$this->name = $m->get_name();
		$this->age = $m->get_age();
		$this->address = $m->get_address();
		$this->cause = $m->get_cause();
		$this->comment = $m->get_comment();

		$this->save_stmt->execute();
	}

}

?>


