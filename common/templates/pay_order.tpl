<!DOCTYPE html>
<html>
<head>
  <meta content="text/html; charset=UTF-8" http-equiv="content-type">
  <link rel="stylesheet" type="text/css" href="../common/css/bootstrap.css" />
  <link rel="stylesheet" type="text/css" href="../common/css/main.css" />
  <script type="text/javascript" src="../common/js/jquery.dev.js"></script>
  <script type="text/javascript" src="../common/js/main.js"></script>
<script type="text/javascript">
var 
     s_hash = '{$fields.Hash}',
     s_orderno = {$fields.OrderNo}
</script>  
</head>
<body>
  <div style="margin:20px; border: 1px solid #DDD;">  
    <div style="margin:15px">
    <h3>Оплата заказа №<b>{$fields.OrderNo}</b> </h3>

    <b>Информация:</b><br>
    Аккаунт: <b>{$fields.Account}</b><br>
    Описание: <b>{$fields.Descr}</b><br>
    Оплачено: <b id="total_confirmed">{$fields.SumConfirmed}</b><br>
    Не пдтверждено: <b id="total_unconfirmed">{$fields.SumUnConfirmed}</b><br>
    Ссылка на заказ: <a href="bitserver.php?action=pay&OrderNo={$fields.OrderNo}&Hash={$fields.Hash}" target="_blank" >заказ</a><br>
    <br>
    Для зачисления платежа оплатите <b>{$fields.OutSum|string_format:"%f"}</b> на кошелек <b>{$fields.BtcAddress}</b> BTC<br>
    </div>
    <div id="info" style="margin:15px;">
    &nbsp;
    </div>
    <div class="alert-message block-message success" id="success_msg" style="display:none;">
       Заказ успешно оплачен!
      </div>
       <a href="js_error.html" onclick="BackToShop();return false" class="btn success" id="success_btn" style="display:none;">Вернутся в магазин</a>  
    <a href="js_error.html" onclick="refresh_account_balance();return false" class="btn" id="check_btn">Проверить оплату</a>
    <a href="js_error.html" onclick="test_refill();return false" class="btn" id="test_refill_btn">Тестовое зачисление</a>
          <div>
           <div style="float:left;">{$smarty.const.SM_TRANSACTIONS_LIST}</div> 
           <div style="float:right;"><a  href="js_error.html" onclick="refresh_transactions();return false" class="btn">{$smarty.const.SM_REFRESH_TRANSACTIONS}</a></div>
         </div>
        <br><br>
        <div id="transaction_list">&nbsp;</div>
       </div>    
    </div>  
   {include file='footer.tpl'}
</body>
</html>

