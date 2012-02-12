<?php
function TestRefil($OrderNo)
{
    try {
         $TestBank = 'WalletBank';
         $OrderData = GetOrderData($OrderNo);
         $BitPay = new BitPay($TestBank);
         $BtcAddressId = $OrderData['BtcAddressId'];
         $OutSum = $OrderData['OutSum']-$OrderData['SumConfirmed']-$OrderData['SumUnConfirmed'];
         
         $BankBalance = $BitPay->getbalance($TestBank,1);
         
         if ($OutSum == 0) {
             echo 'Заказ полностью оплачен, ждите подтверждения';
             exit;
         }
         elseif ($BankBalance < $OutSum) {
             echo 'Недостаточно тестовых средств для пополнения, доступно <b>' . ($BankBalance - $OutSum) . '</b> btc ';
             exit;
         }
         elseif ($OutSum > $BankBalance/3) {
             echo 'Слишком большая сумма для тестовой оплаты, максимум <b>' . $BankBalance/3 . '</b> btc ';
             exit;
         }
         else {
             $BtcAddressIdTo = $BitPay->getaddressesbyaccount($BtcAddressId);
             if (isset($BtcAddressIdTo)){
                $BtcAddressIdTo = $BitPay->validate_address($BtcAddressIdTo[0]);
                echo "определили адрес <b>$BtcAddressIdTo</b> ... <br>"; 
                if (isset($BtcAddressIdTo)) {
                   echo "отправляем тестовые монеты <b>$OutSum</b> BTC... <br>"; 
                   $transaction = $BitPay->sendfrom($TestBank,$BtcAddressIdTo,$OutSum,1,"Test refill for order: $OrderData[Descr] $OrderData[OrderNo],  ItemNo: $OrderData[ItemNo] , account: $OrderData[Account]",'Comment to');
                   if (isset($transaction)) {
                      echo "тестовое пополнение прошло успешно, транзакция - <b>$transaction</b><br>"; 
                      echo "ожидайте подтверждения<br>"; 
                      exit;
                   }
                   else {
                       echo 'Не удалось совершить платеж'; 
                       exit;
                   }
                }
            }
         }
         
         
         
         return $result;
    }
    catch (Exception $e) {
        return -1;
    }    
    
    
}

?>