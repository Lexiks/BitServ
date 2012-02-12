<?php
  
include_once "db/mysql.php";
$db=DbSimple_Generic::connect("mysql://".DB_User.":".DB_Password."@".DB_Host."/".DB_Databse);
$db->setErrorHandler('databaseErrorHandler');
$db->query('SET NAMES ?','utf8');

function databaseErrorHandler($message, $info, $e)
{
	if (DB_ShowError) {
	echo "SQL Error: $message<br><pre>"; 
	print_r($info);
	echo "</pre>";
	exit();
       }
}


?>
