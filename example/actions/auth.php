<?php

function loginza_api_request ($url) {
        if ( function_exists('curl_init') ) {
                $curl = curl_init($url);
                $user_agent = 'Loginza-API';

                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                $raw_data = curl_exec($curl);
                curl_close($curl);
                return $raw_data;
        } else {
                return file_get_contents($url);
        }
}

function GetTokenData($token)
{
    $json_login_data = loginza_api_request("http://loginza.ru/api/authinfo?token=$token&id=$id&sig=$sig");
    $login_data = json_decode($json_login_data,true);
    return $login_data;
}

function AddNewUser($login_data)
{
    global $db;
    $UserNo = $db->query('INSERT INTO Users (email,nickname,name,identity,provider) VALUES (?,?,?,?,?)',
                         $login_data['email'],$login_data['nickname'],$login_data['email'],$login_data['identity'],$login_data['provider']);
    return $UserNo;
}

function UpdateUserName($UserNo,$Account)
{
    global $db;
    $Account = preg_replace ("/[^a-zA-Z0-9]/","",$Account);
    if (empty($Account)) {
       echo "Неверное имя";
       ShowUsernamePrompt();
    }
    else {
      $res = $db->query('UPDATE Users SET Account = ? where UserNo = ?d',$Account,$UserNo);
      return $res;
    }
}

function GetUserById($identity)
{
    global $db;
    $users_data = $db->query('SELECT * FROM Users where identity = ?',$identity);
    if (isset($users_data) && (count($users_data) > 0)) {
        return $users_data[0];
    }
    else {
        return null;
    }
    
    
}


function LogOut()
{
    unset($_SESSION['UserNo']);
    unset($_SESSION['Account']);
    header("Location: index.php");
}

function LoginError()
{
    unset($_SESSION);
}



function CheckAuth($token){
   $login_data = GetTokenData($token);
   if (!isset($login_data['error_type'])) {
       $users_data = GetUserById($login_data['identity']);
       if (isset($users_data) && count($users_data) > 0){
           $_SESSION['UserNo'] = $users_data['UserNo'];
           $_SESSION['Account'] = $users_data['Account'];
	       header("Location: index.php");
       }
       else {
            $UserNo = AddNewUser($login_data);
            $_SESSION['UserNo'] = $UserNo;
            ShowUsernamePrompt();
            
       }
   }              else {
       LoginError();
   }
   
   
}

  function ShowUsernamePrompt()
  {
      global $smarty;
      $smarty->caching = false;
      $smarty->display('get_username.tpl');
      exit;
  }

function loginza_get_current_url () {
        $url = array();
        // проверка https
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') {
                $url['sheme'] = "https";
                $url['port'] = '443';
        } else {
                $url['sheme'] = 'http';
                $url['port'] = '80';
        }
        // хост
        $url['host'] = $_SERVER['HTTP_HOST'];
        // если не стандартный порт
        if (strpos($url['host'], ':') === false && $_SERVER['SERVER_PORT'] != $url['port']) {
                $url['host'] .= ':'.$_SERVER['SERVER_PORT'];
        }
        // строка запроса
        if (isset($_SERVER['REQUEST_URI'])) {
                $url['request'] = $_SERVER['REQUEST_URI'];
        } else {
                $url['request'] = $_SERVER['SCRIPT_NAME'] . $_SERVER['PATH_INFO'];
                $query = $_SERVER['QUERY_STRING'];
                if (isset($query)) {
                  $url['request'] .= '?'.$query;
                }
        }

        return $url['sheme'].'://'.$url['host'].$url['request'];
}
?>