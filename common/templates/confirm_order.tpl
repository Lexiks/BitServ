<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="../common/css/bootstrap.css" />
  <link rel="stylesheet" type="text/css" href="../common/css/main.css" />

</head>
<body>

    <div style="margin:15px" align=center>
        <div  style="padding:30px; ; background-color:#DDD; width:500px; border: 1px solid black;">
            <div style="margin:10px">
              Оплата заказа № <b>{$fields.OrderNo}</b> на сумму <b>{$fields.OutSum}</b> BTC для аккаунта <b>{$fields.Account}</b><br>
              Название товара: <b>{$fields.Descr}</b>
            </div>
            <form action='../server/bitserver.php' method=POST target="_blank">
                <input type=hidden name="action" value='pay'>
                <input type=hidden name="OrderNo" value={$fields.OrderNo}>
                <input type=hidden name="Hash" value="{$fields.Hash}">
                <input type=submit value='Все верно, перейти к оплате' class="btn success">
            </form>
            
        </div>
    </div>
   {include file='footer.tpl'}
</body>
</html>
