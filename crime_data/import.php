#!/usr/bin/php
<?
mysql_connect('localhost','root','demons156'); // MAMP defaults
mysql_select_db('comp3550_a2');
$files = glob('*.csv');
foreach($files as $file){
	echo $file."\n";
    mysql_query("LOAD DATA INFILE '".$file."' INTO TABLE crime");
}