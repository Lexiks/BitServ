<?php

function ProcessOrder($OrderData)
{
   if (isset($OrderData)) {
       $ItemData = GetItemData($OrderData['ItemNo']);
       //...
      return true;
   }
   else  return false;
}

function CompleteOrder($OrderData)
{
    if (ProcessOrder($OrderData)){
        UpdateOrderStatus($OrderData['OrderNo'],'Delivered');
      }
}


?>