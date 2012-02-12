<?php

  session_start();

  include_once ("../common/include.php");
  include_once ("actions/btc_act.php");
  
$action = $_REQUEST['action'];
$SessionHash = $_SESSION['Hash'];
$RequestHash = $_REQUEST['Hash'];
$OrderNo = (int)$_REQUEST['OrderNo'];


if (isset($SessionHash)) $CanAccess = ($SessionHash === $RequestHash);
else $CanAccess =  DbCheckHash($OrderNo,$RequestHash);

if (!$CanAccess) {
      ReturnHtmlResult(array('result' => 'error', 'reason' => "Wrong hash"));
   }

   switch ($action) {
         case 'pay' : {
              $fields = ProcessOrderRequest($OrderNo);
              if (isset($fields)){
                  $smarty->assign('fields',$fields);
                  $smarty->display('pay_order.tpl');
              }
              else ReturnJsonResult(array('result' => 'error', 'reason' => 'Error during order process')); 
         } ; break;
         
         case 'check_account' : {
              $SumPayed = AjaxCheckPayment($OrderNo);
              if (isset($SumPayed)) {
                  ReturnJsonResult($SumPayed);
              }
            };break;
            
         case  'get_transactions' : {
              ShowTransactions($OrderNo);
            };break;
            
         //Debug only!
         case  'test_refil' : {
             include_once ("actions/debug_func.php");
             TestRefil($OrderNo);
            };break;
         
      }
             
?>