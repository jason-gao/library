<?php

namespace Library;

class CurlLogin
{
    private $cookieFile;

    public function __construct($cookieFile = '/tmp/cookie.txt')
    {
        $this->cookieFile = $cookieFile;
    }


    public function saveCookie($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieFile);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    public function login($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieFile);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    public function getInfo($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieFile);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }


    public function post($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, is_array($params) ? http_build_query($params) : $params);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieFile);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }


}

$curlLoginObj = new CurlLogin();

$data = $curlLoginObj->saveCookie('http://wp.me/wp-login.php');
//echo $data . "\n";

$data = $curlLoginObj->login('http://wp.me/wp-login.php', ['log' => 'xyui', 'pwd' => '123456']);
echo $data . "\n";


$addLabel = $curlLoginObj->post('http://wp.me/wp-admin/admin-ajax.php', 'action=add-tag&screen=edit-post_tag&taxonomy=post_tag&post_type=post&_wpnonce_add-tag=050c7fe9da&_wp_http_referer=%2Fwp-admin%2Fedit-tags.php%3Ftaxonomy%3Dpost_tag&tag-name=test&slug=test&description=test');
//echo $addLabel . "\n";