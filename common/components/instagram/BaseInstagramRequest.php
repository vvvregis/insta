<?php

namespace common\components\instagram;
class BaseInstagramRequest
{
    const INSTAGRAM_URL = 'https://i.instagram.com/api/v1/';
    const USER_AGENT = 'Instagram 6.21.2 Android (19/4.4.2; 480dpi; 1152x1920; Meizu; MX4; mx4; mt6595; en_US)';

    public function createRequest($url, $options)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::INSTAGRAM_URL . $url);
        curl_setopt($ch, CURLOPT_USERAGENT, self::USER_AGENT);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        if($options['post']) {
            curl_setopt($ch, CURLOPT_POST, 1);
            if ((version_compare(PHP_VERSION, '5.5') >= 0)) {
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $options['postData']);
        }

        if($options['cookies']) {
            curl_setopt($ch, CURLOPT_COOKIEFILE,   dirname(__FILE__). '/cookies.txt');
        } else {
            curl_setopt($ch, CURLOPT_COOKIEJAR,  dirname(__FILE__). '/cookies.txt');
        }
        $response = curl_exec($ch);
        $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return array($http, $response);
    }
}