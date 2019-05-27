<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function is_email($str)
{
    //检验email
    return preg_match("/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/", $str);
}

function is_postcode($str)
{
    //检验邮编
    return preg_match("/^[1-9]\d{5}$/", $str);
}

function is_mobile($str)
{
    //检验是否是手机
    return preg_match("/^(13|15|18|14|17|19)\d{9}$/", $str);
}

//验证内容
function is_content($str)
{
    return preg_match('/^[\p{Han}\p{N}\p{P}]{2,100}$/u', $str);  //验证2~100个汉字
}

function is_name($str)
{
    return preg_match("/^[\x{4e00}-\x{9fa5}]{2,4}+$/u", $str);  //验证2~4个汉字
}

function is_address($str)
{
    return preg_match("/^[\x{4e00}-\x{9fa5}\d\w-]{2,50}$/iu", $str);  //验证地址2~50个汉字
}

function clean($str)
{

    $str = str_replace("_", "\_", $str);    //把'_'过滤掉
    $str = str_replace("%", "\%", $str);    //把'%'过滤掉
    $str = str_replace("*", "\*", $str);    //把'*'过滤掉
    $str = htmlspecialchars($str);    //html标记转换
    $str = str_replace("and", "", $str);
    $str = str_replace("execute", "", $str);
    $str = str_replace("update", "", $str);
    $str = str_replace("count", "", $str);
    $str = str_replace("chr", "", $str);
    $str = str_replace("mid", "", $str);
    $str = str_replace("master", "", $str);
    $str = str_replace("truncate", "", $str);
    $str = str_replace("char", "", $str);
    $str = str_replace("declare", "", $str);
    $str = str_replace("select", "", $str);
    $str = str_replace("create", "", $str);
    $str = str_replace("delete", "", $str);
    $str = str_replace("insert", "", $str);
    $str = str_replace("'", "", $str);
    $str = str_replace(" ", "", $str);
    $str = str_replace("or", "", $str);
    $str = str_replace("=", "", $str);
    $str = str_replace("%20", "", $str);
    //$str = str_replace("on","",$str);
    $str = str_replace("c:/windows/win.ini", "", $str);
    $str = str_replace("file:///etc/passwd", "", $str);
    $str = str_replace("data://text/plain;ba", "", $str);
    $str = str_replace("http://cirt.lnet/rfi", "", $str);
    $str = str_replace("../../../../../../..", "", $str);
    $str = str_replace("alert()", "", $str);
    $str = str_replace(";", "", $str);
    $str = str_replace("file:///rc.d/rc", "", $str);
    return $str;
}

// 获取真实ip
function get_client_ip($type = 0, $adv = false)
{
    $type = $type ? 1 : 0;
    static $ip = NULL;
    if ($ip !== NULL) {
        return $ip[$type];
    }

    if ($adv) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos = array_search('unknown', $arr);
            if (false !== $pos) {
                unset($arr[$pos]);
            }

            $ip = trim($arr[0]);
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u", ip2long($ip));
    $ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}

function week()
{
    $day = array('星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六');
    $week_day = date('w');
    switch ($week_day) {
        case 0:
            return $day[0];
            break;
        case 1:
            return $day[1];
            break;
        case 2:
            return $day[2];
            break;
        case 3:
            return $day[3];
            break;
        case 4:
            return $day[4];
            break;
        case 5;
            return $day[5];
            break;
        case 6;
            return $day[6];
            break;
    }
}
