<?php
include "OpenFunction.php";
foreach($_POST as $key => $value) {
    $post[$key] = FormSubArray($value);
}
/*--------------------------用户登录---------------------------------------------*/
if ($_GET['type'] == 'usLogin') {
    //赋值
    $accountNumber = $post['accountNumber'];//用户登录账号/手机号码
    $khpas = $post['khpas'];//用户登录密码
    $verificationCode = $post['verificationCode'];//验证码
    //判断
    if(empty($accountNumber)){
        $json['warn'] = "请输入登录账号";
    }else if(empty($khpas)){
        $json['warn'] = "请输入登录密码";
    }else if(empty($verificationCode)){
        $json['warn'] = "请输入验证码";
    }elseif($verificationCode != $_SESSION["yan"]){
        $json['warn'] = "验证码输入错误";
    }else{
        $client = mysql_fetch_array(mysql_query("select * from kehu where accountNumber = '$accountNumber' and khpas = '$khpas' "));
        if($client['accountNumber'] != $accountNumber){
            $json['warn'] = "登录账号或密码错误";
        }else{
            if(isMobile()){
                $json['href'] = "{$root}m/mUser/mUser.php";
            }else{
                $json['href'] = "{$root}user/user.php";
            }
            $_SESSION['khid'] = $client['khid'];
            $json['warn'] = "2";
        }
    }
}
else if ($_GET['type'] == 'mUsLogin') {
    //赋值
    $accountNumber = $post['accountNumber'];//用户登录账号/手机号码
    $khpas = $post['khpas'];//用户登录密码
    //判断
    if(empty($accountNumber)){
        $json['warn'] = "请输入登录账号";
    }else if(empty($khpas)){
        $json['warn'] = "请输入登录密码";
    }else{
        $client = mysql_fetch_array(mysql_query("select * from kehu where accountNumber = '$accountNumber' and khpas = '$khpas' "));
        if($client['accountNumber'] != $accountNumber){
            $json['warn'] = "登录账号或密码错误";
        }else{
            if(isMobile()){
                $json['href'] = "{$root}m/mUser/mUser.php";
            }else{
                $json['href'] = "{$root}user/user.php";
            }
            $_SESSION['khid'] = $client['khid'];
            $json['warn'] = "2";
        }
    }
}
/*-----------------返回信息---------------------------------------------------------*/
echo json_encode($json);
?>