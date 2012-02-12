<?php

  include_once ("../client/result.php");      

function ProcessOrderRequest($OrderNo)
{    
    if (isset($OrderNo)) {
        $OrderData = GetOrderData($OrderNo);
        if (isset($OrderData)) { 
                if (!isset($OrderData['BtcAddress'])) {

                   $BitPay = new BitPay($OrderData['BtcAddressId']); 
                   $OrderData['BtcAddress'] = $BitPay -> getnewaddress($OrderData['BtcAddressId']);
                   UpdateOrderAddress($OrderNo,$OrderData['BtcAddress']);
                }
                else
                {
                   $BitPay = new BitPay($OrderData['BtcAddressId']);
                   $OrderData['BtcAddress'] = $BitPay ->  validate_address($OrderData['BtcAddress']);
                }
                   
                if (isset($OrderData['BtcAddress'])) {
                    return $OrderData; 
                }
                else ReturnHtmlResult(array('result' => 'error', 'reason' => 'Error address'));
        }
        else ReturnHtmlResult(array('result' => 'error', 'reason' => 'Cant find order'));
    }
    else ReturnHtmlResult(array('result' => 'error', 'reason' => 'Empty order'));
    return null;
}

function CheckPayment($OrderData)  
{
         if (isset($OrderData)) {
             if (in_array($OrderData['Status'],array('Payed','Delivered'))) {
                $SumConfirmed = $OrderData['SumConfirmed'];
                $SumUnConfirmed = $OrderData['SumUnConfirmed'];
                $IsPayed = true;
             }
             else
             {
                $BtcAddressId = $OrderData['BtcAddressId'];
                $OrderNo = $OrderData['OrderNo'];
                
                $BitPay = new BitPay($BtcAddressId);
                $SumConfirmed = $BitPay -> GetUserBTCBalance($BtcAddressId,0);
                $SumUnConfirmed = $BitPay -> GetUserBTCBalance($BtcAddressId,0)-$SumConfirmed;
                $IsPayed = ($SumConfirmed >= $OrderData['OutSum']);
                $update_sum_result = UpdateOrderSumData($OrderNo,$SumConfirmed,$SumUnConfirmed);
                if ($IsPayed) {
                   UpdateOrderStatus($OrderNo,'Payed');
                }
                elseif (
                        (($SumConfirmed > 0) && ($OrderData['SumConfirmed'] != $SumConfirmed)) || 
                        (($SumUnConfirmed > 0) && ($OrderData['SumUnConfirmed'] != $SumUnConfirmed))
                       ) {
                   UpdateOrderStatus($OrderNo,'PartPayed');           
                }
                       
                if ($IsPayed) {
                   CompleteOrder($OrderData);
                }
             }
              
            return array('SumConfirmed' => $SumConfirmed,'SumUnConfirmed' => $SumUnConfirmed,'Result' => $IsPayed );
         }
}
  
function AjaxCheckPayment($OrderNo)
{
        try {
             $OrderData = GetOrderData($OrderNo);
             $result = CheckPayment($OrderData);
             return $result;
        }
        catch (Exception $e) {
            return null;
        }    
    
}      

  function ShowTransactions($OrderNo)
  {
      global $BitPay,$smarty;

          $OrderData = GetOrderData($OrderNo);
          
          $BitPay = new BitPay($OrderData['BtcAddressId']);
          $transactions = $BitPay->GetUserTransactions();
          
          $smarty->assign('transactions',$transactions);
          $smarty->display('transactions.tpl');
          exit;
  }

function ReCheckPayments()
{
    $unpayed_data = GetUnpayed();
    if (isset($unpayed_data)) {
        foreach ($unpayed_data as $unpayed)   {
                $unpayed['BtcAddressId'] = GetAddressId($unpayed['Account'],$unpayed['OrderNo'],$unpayed['hash']);
                CheckPayment($unpayed);
        }
    }
}



?>