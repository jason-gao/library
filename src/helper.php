<?php
/**
 * Desc:
 * Created by PhpStorm.
 * User: jason-gao
 * Date: 2018/2/11 14:55
 */

/**
 * @return bool Whether the host machine is running a Windows OS
 */
function isWindows()
{
    return defined('PHP_WINDOWS_VERSION_BUILD');
}


/**
 * @param $hostname
 * @return array
 * @node_name 系统命令获取mx记录，exec一般禁用，这只是一种实现而已
 * @link
 * @desc
 * 系统函数：http://php.net/manual/zh/function.getmxrr.php
 */
function getMxRecords($hostname)
{
    $mxHosts = [];
    exec('nslookup -type=mx ' . $hostname, $result_arr);
    foreach ($result_arr as $line) {
        if (preg_match("/.*mail exchanger = (.*) (.*)/", $line, $matches))
            $mxHosts[] = $matches[2];
    }

    return $mxHosts;
}


//demo
//$details = array(
//    array("id" => "1", "name" => "Mike", "num" => ['1' => 'test']),
//    array("id" => "2", "name" => "Carissa", "num" => "08548596258"),
//    array("id" => "1", "name" => "Mike", "num" => ['1' => 'test']),
//);
//$details = super_unique($details);
//print_r($details);

/**
 * @param $array
 * @return array
 * @node_name 多维数组去重
 * @link
 * @desc
 */
function super_unique($array)
{

    $result = array_map("unserialize", array_unique(array_map("serialize", $array)));

    foreach ($result as $key => $value) {
        if (is_array($value)) {
            $result[$key] = super_unique($value);
        }
    }

    return $result;
}


/*
 * 二维数组排序
 */
function array_sort($arr, $key, $order = "desc")
{
    $keyvalue = $new_arr = array();
    foreach ($arr as $k => $v) {
        $keyvalue[$k] = $v[$key];
    }
    switch ($order) {
        case "desc":
            arsort($keyvalue);
            break;
        default:
            asort($keyvalue);
            break;
    }
    foreach ($keyvalue as $k => $v) {
        $new_arr[$k] = $arr[$k];
    }

    return array_values($new_arr);
}

//二维数组去重
function assoc_unique($arr, $key)
{
    $tmp_arr = array();
    foreach ($arr as $k => $v) {
        if (in_array($v[$key], $tmp_arr)) {
            unset($arr[$k]);
        } else {
            $tmp_arr[] = $v[$key];
        }
    }
    sort($arr);

    return $arr;
}


/**
 * @param string $index_key
 * @param $arr
 * @return array
 * @node_name 二维数组记录分组
 * @link
 * @desc
 */
function array_column_group($index_key = 'id', $arr)
{
    if ($arr && is_array($arr)) {
        $res = [];
        foreach ($arr as $k => $v) {
            $res[$v[$index_key]][] = $v;
        }

        return $res;
    }

    return $arr;
}

/**
 * @param int $length
 * @return bool|string
 * @node_name 生成随机字符串
 * @link
 * @desc
 */
function generateRandomStr($length = 20)
{
    $ccid         = str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789', 5));
    $random_start = mt_rand(0, (strlen($ccid) - $length));
    $code         = substr($ccid, $random_start, $length);

    return $code;
}


