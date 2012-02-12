$(document).ready(function() {
    refresh_account_balance();
    refresh_transactions();

});


function SuccessResult()
{
  $('#success_msg').show();
  $('#success_btn').show();
  $('#test_refill_btn').hide();
  $('#check_btn').hide();

}

function BackToShop()
{
    window.location = '../client/bitclient.php?action=success';
}


function refresh_account_balance()
{
    $('#total_confirmed').html("<img src='../common/img/ajax-loader.gif'/>");   
    $('#total_unconfirmed').html("<img src='../common/img/ajax-loader.gif'/>");   

    $.getJSON("bitserver.php?action=check_account&OrderNo="+s_orderno+"&Hash="+s_hash)
       .success( function(json_data){
        $('#total_confirmed').text(json_data.SumConfirmed); 
        $('#total_unconfirmed').text(json_data.SumUnConfirmed); 
        refresh_transactions();
        if (json_data.Result)
            {
                SuccessResult();
            }

       });
}

function refresh_transactions()
{
    $('#transaction_list').fadeOut('fast', function () {
      $('#transaction_list').html("<img src='../common/img/ajax-loader.gif'/>");   
      $('#transaction_list').load("bitserver.php?action=get_transactions&OrderNo="+s_orderno+"&Hash="+s_hash, function () { $('#transaction_list').fadeIn(); });
    });
    
}

//Debug only
function test_refill()
{
  $('#info').html("<img src='../common/img/ajax-loader.gif'/>");   
     $('#test_refill_btn').hide();
  $('#info').load("bitserver.php?action=test_refil&OrderNo="+s_orderno+"&Hash="+s_hash, 
     function () {
      refresh_account_balance();
      refresh_transactions()
      setTimeout("$('#info').html('')",8000);

    }
  );
}

