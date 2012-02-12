<?php

function ReturnJsonResult($res) {
   echo json_encode($res);
   exit;
}     

function ReturnHtmlResult($res) {
   global $smarty;
   $smarty->assign('result',$res['result']);
   $smarty->assign('reason',$res['reason']);
   $smarty->display('result.tpl');
   exit;
} 

function GetAddressId($Accont,$OrderNo,$Hash)
{
    return md5($Accont.$OrderNo.$Hash);
}
?>