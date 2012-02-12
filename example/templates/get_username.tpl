<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
</head>
<body>

<div class="container">
   <div class="content" style="margin:30 0 5;">
        <div class="page-header" style="height:22px;!important">
          <h4>Успешно зарегистрировались! Под каким логином Вас запомнить?</h4>
        </div>
          
          <form method="POST" action="index.php?action=set_name">
            <input  name="action" type=hidden value="set_name">
            <input  name="Account" size="40" value="" class="input-small" type="text" >
            <button type="submit" class="btn bin-success">Enter</button>
          </form>

      </div>

    </div>
   {include file='footer.tpl'}
</body>
</html>
