<!DOCTYPE html>
<html>
    <head>
      <meta content="text/html; charset=UTF-8" http-equiv="content-type">
      <link rel="stylesheet" type="text/css" href="../common/css/bootstrap.css" />
    </head>

    <body>
      <div align=center>  
        <table id="orders_table"  class="bordered-table" style="width:700px;margin-top:30px;">
           <tr>

             <th></th>
             <th>№</th>
             <th>Дата</th>
             <th>Аккаунт</th>
             <th>Адрес</th>
             <th>Сумма у оплате</th>
             <th>Подтверждено</th>
             <th>Не подтверждено</th>
             <th>Статус</th>
             <th>id Товара</th>
             <th>Кол-во</th>             
             <th>Описание</th>
             </tr>

        {foreach from=$orders key=k item=v}
           <tr class="{$v.Status}">
             <td> <img src = "../common/img/s_{$v.Status|lower}.png"/></td>
             <td class="intext"><a href='bitserver.php?action=pay&OrderNo={$v.OrderNo}&Hash={$v.Hash}' target="_blank">{$v.OrderNo}</a></td>
             <td class="intext">{$v.Date|date_format:"%d.%m.%Y %T"}</td>
             <td class="intext">{$v.Account}</td>
             <td class="intext">{$v.BtcAddress}</td>
             <td class="intext">{$v.OutSum}</td>
             <td class="intext">{$v.SumConfirmed}</td>
             <td class="intext">{$v.SumUnConfirmed}</td>
             <td class="intext">{$v.Status}</td>
             <td class="intext">{$v.ItemNo}</td>
             <td class="intext">{$v.Count}</td>
             <td class="intext">{$v.Descr}</td>
             
           </tr>
        {/foreach}
        </table>
       </div>
      <a href="admin.php?action=cron"  class="btn" id="success_btn">Разнести платежи</a>  
   {include file='footer.tpl'}
    <body>
</html>