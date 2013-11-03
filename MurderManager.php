<?php

interface MurderManager
{
	public function get_murder_by_id( $id );
	public function get_murders_by_name( $name );
	public function get_murders_by_age( $age );
	public function get_murders_by_address( $address );
	public function get_murders_by_comment( $comment );
	public function get_murders_by_cause( $cause );
}

?>