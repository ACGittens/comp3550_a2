<?php

class Model
{
	abstract public function save();

	public function get_details()
	{
		$output = "";
		$model_properties = get_class_vars( get_class($this) );
		foreach( $model_properties as $name=>$value )
		{
			$output .= $name.": ".$value."\n";
		}
		return $output;
	}
}


?>