<?php
  error_reporting(5);

  define(__ROOT__ , $_SERVER['DOCUMENT_ROOT'] );
  include_once ("include/config.php");
  include_once ("include/smarty_init.php");

  include_once ("modules/db_mod.php");
  include_once ("modules/common_mod.php");

  include_once ("include/connect.php");

  if (!function_exists('json_encode')) 
      include_once ("include/json.php");
  include_once ("include/class.bitcoin.php");
?>