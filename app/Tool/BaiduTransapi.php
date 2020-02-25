<?php

namespace App\Tool;

/**
 * @file baidu_transapi.php 
 * @author mouyantao(mouyantao@baidu.com)
 * @date 2015/06/23 14:32:18
 * @brief 
 *  
 **/



class Baidutransapi {
    var $lang;

    var $url='http://api.fanyi.baidu.com/api/trans/vip/translate';
    var $app_id='20170310000041950';
    var $sec_key='YUyDZ30snH59G3OJ5ViN';

function __construct($lang1){

    $this->lang=$lang1;
}


//翻译入口
function translate($name, $from, $to )
{
   



       $args = array(
            'q' => $name,
            'appid' => $this->app_id,
            'salt' => rand(10000,99999),
            'from' => $from,
            'to' => $to,

        );

        $args['sign'] = $this->buildSign($name, $this->app_id, $args['salt'], $this->sec_key);

        $ret = $this->call($this->url, $args);

        $ret = json_decode($ret, true);


          
     /*  缓存*/
      $this->lang->write($name,$ret['trans_result'][0]['dst']);


         return $ret['trans_result'][0]['dst']; 


 
}

//加密
function buildSign($query, $appID, $salt, $secKey)
{/*{{{*/
   
    $str = $appID . $query . $salt . $secKey;
    $ret = md5($str);
    return $ret;
}/*}}}*/

//发起网络请求
function call($url, $args=null, $method="post", $testflag = 0, $timeout = 10, $headers=array())
{/*{{{*/

    $ret = false;
    $i = 0; 
    
    while($ret === false) 
    {
        if($i > 1)
            break;
        if($i > 0) 
        {
            sleep(1);
        }
        $ret = $this->callOnce($url, $args, $method, false, $timeout, $headers);
        $i++;
    }
    return $ret;
}/*}}}*/

function callOnce($url, $args=null, $method="post", $withCookie = false, $timeout = 10, $headers=array())
{/*{{{*/
    $ch = curl_init();
    if($method == "post") 
    {
        $data = $this->convert($args);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_POST, 1);
    }
    else 
    {
        $data = $this->convert($args);
        if($data) 
        {
            if(stripos($url, "?") > 0) 
            {
                $url .= "&$data";
            }
            else 
            {
                $url .= "?$data";
            }
        }
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if(!empty($headers)) 
    {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    if($withCookie)
    {
        curl_setopt($ch, CURLOPT_COOKIEJAR, $_COOKIE);
    }
    $r = curl_exec($ch);
    curl_close($ch);
    return $r;
}/*}}}*/

function convert(&$args)
{/*{{{*/
    $data = '';
    if (is_array($args))
    {
        foreach ($args as $key=>$val)
        {
            if (is_array($val))
            {
                foreach ($val as $k=>$v)
                {
                    $data .= $key.'['.$k.']='.rawurlencode($v).'&';
                }
            }
            else
            {
                $data .="$key=".rawurlencode($val)."&";
            }
        }
        return trim($data, "&");
    }
    return $args;
}/*}}}*/



}

?>
