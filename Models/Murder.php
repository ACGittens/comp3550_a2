<?php

require_once('Model.php');
define("INVALID_ID",0);

class Murder implements Model
{
	private $id;
	private $name;
	private $address;
	private $cause;
	private $age;
	private $comment;

	private static $murder_manager;

	function __construct( $name, $age, $address, $cause, $comment )
	{
		$this->set_name($name);
		$this->set_age($age);
		$this->set_address($address);
		$this->set_cause($cause);
		$this->set_comment($comment);
	}


	public static function set_murder_manager( $murder_manager )
	{
		Murder::$murder_manager = $murder_manager;
	}


	public static function get_murder_by_id( $id )
	{
		$murder = Murder::$murder_manager->get_murder_by_id($id);
		return $id;
	}

	public static function get_murders_by_name( $name )
	{
		$murders = Murder::$murder_manager->get_murders_by_name($name);
		return $murders;
	}

	public static function get_murders_by_age( $age )
	{
		$murders = Murder::$murder_manager->get_murders_by_age($age);
		return $murders;
	}

	public static function get_murders_by_address($address)
	{
		$murders = Murder::$murder_manager->get_murders_by_address($address);
		return $murders;
	}


	public static function get_murders_by_cause($cause)
	{
		$murders = Murder::$murder_manager->get_murders_by_cause($cause);
		return $murders;
	}

	public static function get_murders_by_comment($comment)
	{
		$murders = Murder::$murder_manager->get_murders_by_comment($comment);
		return $murders;
	}


	public static function get_all()
	{
		$murders = Murder::$murder_manager->get_all();
		return $murders;
	}

	public static function create_murder( $name, $age, $address, $cause, $comment )
	{
		$new_murder = Murder($name,$age,$address,$cause,$comment);
		$new_murder->set_id(INVALID_ID);
		return $new_murder;
	}

	public static function _create_murder( $id, $name, $age, $address, $cause, $comment )
	{
		$new_murder = Murder::create_murder($name,$age,$address,$cause,$comment);
		$new_murder->set_id($id);
		return $new_murder;
	}

	public function get_id()
	{
		return $this->id;
	}

	public function get_name()
	{
		return $this->name;
	}

	public function get_age()
	{
		return $this->age;
	}

	public function get_address()
	{
		return $this->address;
	}

	public function get_cause()
	{
		return $this->cause;
	}

	public function get_comment()
	{
		return $this->comment;
	}


	public function set_id( $id )
	{
		$this->id = $id;
	}

	public function set_name( $name )
	{
		$this->name = $name;
	}

	public function set_age( $age )
	{
		$this->age = $age;
	}

	public function set_address( $address )
	{
		$this->address = $address;
	}

	public function set_cause( $cause )
	{
		$this->cause = $cause;
	}

	public function set_comment( $comment )
	{
		$this->comment = $comment;
	}

}

?>