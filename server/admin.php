<?php
  include_once ("../common/include.php");
  include_once ("actions/btc_act.php");

  $action = $_GET['action'];

function ShowAllorder()
{
   global $db,$smarty;
    try {
         $order_data= $db->query('SELECT * FROM Orders');

         if (isset($order_data)){
               $smarty->assign('orders',$order_data);
               $smarty->display('orders.tpl');
               exit;
         }
    }
    catch (Exception $e) {
        return null;
    }     
}


  switch ($action) {
      case 'show_orders' :  ShowAllorder();break;
      case 'cron' :  {
                        ReCheckPayments();  
                        ShowAllorder();
                        break;
      }   
  }


  
?>