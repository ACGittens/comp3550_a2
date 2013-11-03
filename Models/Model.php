<?php

abstract class Model
{
	abstract public function save();

	public function get_details()
	{
		$output = "";
		$model_properties = get_class_vars(__CLASS__);
		echo "Class: ".get_class($this)."\n";
		var_dump($model_properties);
		// foreach( $model_properties as $name=>$value )
		// {
		// 	$output .= $name.": ".$value."\n";
		// }
		return $output;
	}
}


?>