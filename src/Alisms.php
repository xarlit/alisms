<?php
namespace alisms;
class Alisms {
    private $url = 'https://dysmsapi.aliyuncs.com?';
    public function __construct($config) {
        date_default_timezone_set("GMT");
        $this->data = array(
            'Action'=>'SendSms',
            'Format'=>'JSON',
            'Version'=>'2017-05-25',
            'AccessKeyId'=>$config['accessKeyId'],
            'SignatureVersion'=>'1.0',
            'SignatureMethod'=>'HMAC-SHA1',
            'SignatureNonce'=>uniqid(),
            'Timestamp'=>date('Y-m-d\TH:i:s\Z'),
        );
        $this->accessKeySecret=$config['accessKeySecret'];
    }
    public function send($param) {
        if(is_array($param)) {
            $this->data=array_merge($this->data,$param);
        }
        $this->data['Signature']=$this->signature($this->data,$this->accessKeySecret);
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$this->url.http_build_query($this->data));
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($ch);
        return json_decode($res,1);
    }
    private function signature($parameters,$accessKeySecret) {
        ksort($parameters);
        $string='';
        foreach($parameters as $key=>$value) {
            $string.='&'.$this->percentEncode($key).'='.$this->percentEncode($value);
        }
        $sign='GET&%2F&'.$this->percentencode(substr($string,1));
        $signature=base64_encode(hash_hmac('sha1',$sign,$accessKeySecret.'&',true));
        return $signature;
    }
    private function percentEncode($str) {
        $res = urlencode($str);
        $res = preg_replace('/\+/','%20',$res);
        $res = preg_replace('/\*/','%2A',$res);
        $res = preg_replace('/%7E/','~',$res);
        return $res;
    }
}