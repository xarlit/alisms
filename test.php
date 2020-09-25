<?php


require_once __DIR__ . '/vendor/autoload.php';

use alisms\Alisms;

$config = [
    'accessKeyId'=>'您的阿里云 accessKeyId',
    'accessKeySecret'=>'您的阿里云 accessKeySecret'
];
$sms = new Alisms($config);
$param = [
    'PhoneNumbers'=>'接收短信的手机号',
    'SignName'=>'短信签名',
    'TemplateCode'=>'短信模板code',
    'TemplateParam'=>'{"msg":"123456"}',
];
$res = $sms->send($param);
var_dump($res);
