<?php
  include_once ("include/config.php");
  include_once ("include/connect.php");
  include_once ("include/smarty_init.php");
  session_start();
  include_once ("actions/auth.php");
  
  $action = $_GET['action'];
  
    switch($action) {
        case 'logout' : LogOut(); break;
        case 'set_name' : {
                           UpdateUserName($_SESSION['UserNo'],$_POST['Account']);           
                           $_SESSION['Account'] = $_POST['Account'];
                           header("Location: index.php");
                        }break;
                        
    }
  if (isset($_REQUEST['token']) && !isset($_SESSION['UserNo'])) {
      CheckAuth($_REQUEST['token']);
  }
  
         $items_data= $db->query('SELECT * FROM Items');
         if (isset($items_data)){
               $smarty->assign('items',$items_data);
               $smarty->assign('UserNo',$_SESSION['UserNo']);
               $smarty->assign('Account',$_SESSION['Account']);
               $smarty->assign('token_url',loginza_get_current_url() );
               $smarty->display('items.tpl');
               exit;
         }
  
?>