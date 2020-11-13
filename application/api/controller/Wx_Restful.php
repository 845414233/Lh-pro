<?php
namespace app\api\controller;
class Wx_Restful
{
        /*微信code*/
         public $code;
         public $appid;
         public $secret;
         public $grant_type="authorization_code";
         public $url;
         public function get_open_id(){
             $ch = curl_init();
             curl_setopt($ch, CURLOPT_URL, $this->url);
             curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
             curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
             curl_setopt($ch, CURLOPT_HEADER, 0);
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
             curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
             $res = curl_exec($ch);
             curl_close($ch);
             return json_decode($res, true);
         }



}