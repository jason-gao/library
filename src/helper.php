<?php
/**
 * Desc: 常用的一些函数
 * Created by PhpStorm.
 * User: jason-gao
 * Date: 2018/2/11 14:55
 */

/**
 * @return bool  Whether the host machine is running a Windows OS
 * @node_name
 * @link
 * @desc
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


/**
 * @param $array
 * @return array
 * @node_name 多维数组去重
 * @link
 * @desc
 *
 * //demo
 * //$details = array(
 * //    array("id" => "1", "name" => "Mike", "num" => ['1' => 'test']),
 * //    array("id" => "2", "name" => "Carissa", "num" => "08548596258"),
 * //    array("id" => "1", "name" => "Mike", "num" => ['1' => 'test']),
 * //);
 * //$details = super_unique($details);
 * //print_r($details);
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


/**
 * @param $arr
 * @param $key
 * @param string $order
 * @return array
 * @node_name 二维数组排序
 * @link
 * @desc
 */
function array_sort($arr, $key, $order = "desc")
{
    $keyValue = $new_arr = array();
    foreach ($arr as $k => $v) {
        $keyValue[$k] = $v[$key];
    }
    switch ($order) {
        case "desc":
            arsort($keyValue);
            break;
        default:
            asort($keyValue);
            break;
    }
    foreach ($keyValue as $k => $v) {
        $new_arr[$k] = $arr[$k];
    }

    return array_values($new_arr);
}

/**
 * @param $arr
 * @param $key
 * @return mixed
 * @node_name 二维数组去重
 * @link
 * @desc
 */
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
 * @param $field //只返回固定字段
 * @return array
 * @node_name 二维数组记录分组
 * @link
 * @desc
 */
function array_column_group($index_key = 'id', $arr, $field = '')
{
    if ($arr && is_array($arr)) {
        $res = [];
        foreach ($arr as $k => $v) {
            $res[$v[$index_key]][] = $field ? $v[$field] : $v;
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
    $shuffleStr   = str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789', 5));
    $random_start = mt_rand(0, (strlen($shuffleStr) - $length));
    $code         = substr($shuffleStr, $random_start, $length);

    return $code;
}


/**
 * @param $arr1
 * @param $arr2
 * @return array
 * @node_name 取arr1和arr2的交集，并且unset掉arr1的交集，返回arr1
 * @link
 * @desc
 * $http = [80,8080,8080,8081];
 * $https = [433,8080,30,8081];
 * $https = array_intersect_unset($https, $http);
 * print_r($https);
 */
function array_intersect_unset($arr1, $arr2)
{
    $inspect = array_intersect($arr1, $arr2);
    $keys    = array_keys($inspect);
    foreach ($keys as $k) {
        unset($arr1[$k]);
    }
    return array_values($arr1);
}


/**
 * @param $cmd
 * @node_name 后台执行命令
 * @link
 * @desc
 */
function execInBackground($cmd)
{
    if (substr(php_uname(), 0, 7) == "Windows") {
        pclose(popen("start /B " . $cmd, "r"));
    } else {
        exec($cmd . " > /dev/null &");
    }
}


/**
 * @param $ip
 * @return mixed
 * @node_name ping
 * @link
 * @desc
 */
function PingUser($ip)
{
    return preg_replace(" ms", "", end(explode("/", exec("ping -q -c 1 $ip"))));
}


/**
 * @param $arr
 * @return array
 * @node_name 过滤空值并且去重
 * @link
 * @desc
 */
function arrFilterUnique($arr)
{
    if (is_array($arr) && $arr) {
        return array_values(array_unique(array_filter($arr)));
    }

    return [];
}


/**
 * @param array $urls
 * @return array
 * @node_name 格式化url为path
 * @link
 * @desc
 * //www.a.com/b -> b
 * //s?a=1 -> /s?a=1
 * http://www.a.com/c  -> /c
 * www.a.com/f -> /f
 * /a -> /a
 */
function formatUrlToPath($urls = [])
{
    $urls      = (array)$urls;
    $parseUrls = [];
    foreach ($urls as $url) {
        if (strpos($url, 'http://') !== 0 && strpos($url, '/') !== 0) {
            $url = '//' . $url;
        }
        if (strpos($url, '//') === 0) {
            if (!preg_match('/^\/\/([A-Z0-9][A-Z0-9_-]*(\.[A-Z0-9][A-Z0-9_-]*)*(\.[A-Z]+)+)(:\d+)?/i', $url)) {
                $url = '/' . ltrim($url, '/');
            }
        }
        $url     = parse_url($url);
        $content = '';
        if ($url['path']) {
            $content .= str_replace(['//'], ['/'], $url['path']);
        }
        if ($url['query']) {
            $content .= '?' . $url['query'];
        }
        if ($url['fragment']) {
            $content .= '#' . $url['fragment'];
        }

        $parseUrls[] = $content;
    }

    return arrFilterUnique($parseUrls);
}

/**
 * @param array $urls
 * @return array
 * @node_name 格式化url为domain
 * @link
 * @desc
 */
function formatUrlToDomain($urls = [])
{
    $urls      = (array)$urls;
    $parseUrls = [];
    foreach ($urls as $url) {
        if (strpos($url, 'http://') !== 0 && strpos($url, '/') !== 0) {
            $url = '//' . $url;
        }
        $url     = parse_url($url);
        $content = '';
        if ($url['host']) {
            $content .= $url['host'];
        }
        $parseUrls[] = $content;
    }

    return arrFilterUnique($parseUrls);
}


/**
 * @param $haystack
 * @param $needles
 * @return bool
 * @node_name 以字符串开头
 * @link
 * @desc
 */
function startsWith($haystack, $needles)
{
    foreach ((array) $needles as $needle) {
        if ($needle !== '' && substr($haystack, 0, strlen($needle)) === (string) $needle) {
            return true;
        }
    }

    return false;
}

/**
 * @param $haystack
 * @param $needles
 * @return bool
 * @node_name 以字符串结尾
 * @link
 * @desc
 */
function endsWith($haystack, $needles)
{
    foreach ((array) $needles as $needle) {
        if (substr($haystack, -strlen($needle)) === (string) $needle) {
            return true;
        }
    }

    return false;
}

