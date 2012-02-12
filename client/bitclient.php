<?php
session_start();
  include_once ("../common/include.php");

$action = $_REQUEST['action'];

     switch ($action) {
             case 'pay' : {
                            
                            $ItemData = GetItemData((int)$_REQUEST['ItemNo']);

                            $ItemData['UserNo'] = (int)$_SESSION['UserNo'];
                            $ItemData['Account'] = $_SESSION['Account'];
                            
                            $ItemData['Count'] = floatval($_REQUEST['Count']);
                            $ItemData['OutSum'] = $ItemData['Price'] * $ItemData['Count'];
                            
                            $_SESSION['Hash'] =  strtoupper(substr(md5(uniqid(microtime(), 1)).getmypid(),1,8));
                            $ItemData['Hash'] = $_SESSION['Hash'];

                            $ItemData['OrderNo']  = AddNewOrder($ItemData);
                           
                            if ($ItemData['OrderNo'] >= 0) {
                                 $smarty->assign('fields',$ItemData);
                                 $smarty->assign('Hash',$_SESSION['Hash']);
                                 $smarty->display('confirm_order.tpl');    
                                }
                            else ReturnHtmlResult(array('result' => 'error', 'reason' => 'Произошла ошибка в процессе выписки счета!!'));
             }; break; 

             case 'success' : {  
                                ReturnHtmlResult(array('result' => 'success', 'reason' => 'Спасибо, наш менеджер свяжется с вами в ближайшее время!'));
             }; break ;

             case 'fail' : {  
                                ReturnHtmlResult(array('result' => 'error', 'reason' => 'Произошла ошибка в процессе оплаты!!'));
             }; break ;                            

     }


?>