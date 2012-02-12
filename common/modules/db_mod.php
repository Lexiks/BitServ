<?php
  

function AddNewOrder($fields)
{
    global $db;
     try {
        
        $OrderNo = $db->query('INSERT INTO Orders (OutSum,ItemNo,Count,UserNo,Hash,Account,Status) VALUES (?f,?d,?d,?f,?,?,"New")',
                            $fields['OutSum'],$fields['ItemNo'],$fields['Count'],$fields['UserNo'],$fields['Hash'],$fields['Account']);
        return $OrderNo;
    }
    catch (Exception $e) {
        return -1;
    }    
}

function GetOrderData($OrderNo)
{
    global $db;
    try {
         $OrderData = $db->query('SELECT Orders.*,Items.Descr as Descr FROM Orders 
                                 LEFT JOIN Items on (Items.ItemNo = Orders.ItemNo) 
                                 WHERE OrderNo = ?d limit 1',(int)$OrderNo);
         if (count ($OrderData) > 0) {
           $OrderData  = $OrderData[0];
           $OrderData['BtcAddressId'] = GetAddressId($OrderData['Account'],$OrderData['OrderNo'],$OrderData['Hash']);
           return $OrderData;
           }
        else return null;
    }
    catch (Exception $e) {
        return null;
    }    
}

function GetItemData($ItemNo)
{
    global $db;
    try {
         $ItemsData = $db->query('SELECT * FROM Items WHERE ItemNo = ?d',(int)$ItemNo);
         if (count ($ItemsData) > 0) {
           $ItemsData  = $ItemsData[0];
           return $ItemsData;
           }
        else return null;
    }
    catch (Exception $e) {
        return null;
    }    
}




function UpdateOrderStatus($OrderNo,$Status)
{
  UpdateOrder($OrderNo,'Status',$Status);
}


function UpdateOrderAddress($OrderNo,$BtcAddress)
{
  UpdateOrder($OrderNo,'BtcAddress',$BtcAddress);
}


function UpdateOrder($OrderNo,$field,$value)
{
    global $db;
    try {
         $update_result = $db->query("UPDATE Orders SET $field = ? WHERE OrderNo = ?d",$value,$OrderNo);
         return $update_result;
    }
    catch (Exception $e) {
        return false;
    }    
    
}

function UpdateOrderSumData($OrderNo,$SumConfirmed,$SumUnConfirmed)
{
    global $db;
    try {
         $update_result = $db->query('UPDATE Orders SET SumConfirmed = ?f,SumUnConfirmed = ?f WHERE OrderNo = ?d',$SumConfirmed,$SumUnConfirmed,$OrderNo);
         return $update_result;
    }
    catch (Exception $e) {
        return false;
    }    
   
}

function GetUnpayed()
{
    global $db;
    try {
        $unpayed_data = $db->query('SELECT OrderNo,Account,OutSum,SumConfirmed FROM Orders WHERE Status in ("New","PartPayed")');
         return $unpayed_data;
    }
    catch (Exception $e) {
        return null;
    }    
    
}

function DbCheckHash($OrderNo,$Hash) 
{
   global $db;
    try {
        $check_data = $db->query('SELECT Count(OrderNo) as cnt FROM Orders WHERE OrderNo = ?d and Hash = ?',$OrderNo,$Hash);
        $check_result = ((isset($check_data)) && (count($check_data) > 0) && $check_data[0]['cnt']);
        return $check_result;
    }
    catch (Exception $e) {
        return false;
    }     
   return false;
}


?>