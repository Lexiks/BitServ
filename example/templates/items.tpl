<!DOCTYPE html>
<html>
    <head>
      <meta content="text/html; charset=UTF-8" http-equiv="content-type">
      <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
      <script type="text/javascript" src="js/jquery.dev.js"></script>      
           <script type="text/javascript">
        {literal}
            function GoToPay(ItemNo)
            {
                
                var link = '{/literal}{$smarty.const.SM_BITCLIENT_PATH}{literal}?action=pay&ItemNo='+ItemNo+'&Count='+$('#count_'+ItemNo).val() ;
                window.open(link);
                console.log(link);
                
            }
            function UpdateSum(ItemNo,Price)
            {
                
                 var sum = $('#count_'+ItemNo).val() * Price;
                 $('#sum_'+ItemNo).html(sum);
                
                console.log(sum);
                
            }
            function ShowLoginForm()
            {
                $('#login_form').show();
            }
        {/literal}
    </script>
    </head>

    <body>
    <div style="margin:10px;height:30px;">
        <div style="margin:10px; float:left">
          <h2>Тестовая витрина.</h2>
        </div>
        
        <div style="margin:10px; float:right ">
            {if $UserNo !== null}
            Добро пожаловать: <b>{$Account} </b>
            <a href="index.php?action=logout" class="btn" id="pay_btn"><i class="icon-off"></i> Выйти</a>
            {else}
            
            <a href="#" onclick="ShowLoginForm(); return false;" class="btn btn-info" id="pay_btn"><i class="icon-user icon-white"></i> Войти</a>
            {/if}
        </div>
    </div>
    <div align=right style="margin:0px; display:none;" id="login_form">
     <script src="http://loginza.ru/js/widget.js" type="text/javascript"></script>
     <iframe src="http://loginza.ru/api/widget?overlay=loginza&token_url={$token_url}" 
     style="width:359px;height:180px;" scrolling="no" frameborder="no"></iframe>
   </div>

      <div align=center>  
        <table id="items_table" class="table table-bordered" style="width:900px;margin-top:30px;" width="700px">
           <tr>

             <th>Id</th>
             <th>Название</th>
             <th>Цена, BTC</th>
             <th>Кол-во</th>             
             <th>Сумма</th>
             <th></th>
             </tr>

        {foreach from=$items key=k item=v}
    <tr>
      <td width="30px">{$v.ItemNo}</td>
      <td width="400px" >{$v.Descr}</td>
      <td width="30px">{$v.Price}</td>
      <td width="30px"><input type=text onkeyup="UpdateSum({$v.ItemNo},{$v.Price})" name=Count value='1' size="1" style="width:50px" id="count_{$v.ItemNo}"></td>
      <td width="70px"><div id="sum_{$v.ItemNo}">{$v.Price}</div></td>
      <td width="70px"><a href="#" onclick="GoToPay({$v.ItemNo});return false" target="_blank" class="btn btn-success" id="pay_btn"><i class="icon-shopping-cart icon-white"></i> Купить</a>  </td>
    </tr>
        {/foreach}
        </table>
       </div>
   {include file='footer.tpl'}
    <body>
</html>