<?php

namespace common\components\instagram;

class InstagramManager
{

    const USERNAME = '';
    const PASSWORD = '';
    const SIGNATURE = '25eace5393646842f0d0c3fb2ac7d3cfa15c052436ee86b5406a8433f54d24a5';

    /**
     * @var InstagramProvider
     * Instagram provider object
     */
    private $request;
    /**
     * @var string
     * Logged user id
     */
    private $uid;
    /**
     * @var string
     * Generated guid
     */
    private $guid;
    /**
     * @var string
     * Emulated device
     */
    private $deviceId;

    /**
     * InstagramManager constructor.
     */
    public function __construct()
    {
        $this->request = new InstagramProvider();
        $this->login();
    }

    /**
     * Generate guid for Instagram login
     * @return string Generated Guid
     */
    private function generateGuid() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(16384, 20479),
            mt_rand(32768, 49151),
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(0, 65535));
    }

    /**
     * Generate signature for Instagram login
     * @param $data
     * @return string generated signature
     */
    private function generateSignature($data) {
        return hash_hmac('sha256', $data, self::SIGNATURE);
    }

    /**
     * Instagram login
     */
    private function login() {
        $this->guid = $this->generateGuid();
        $this->deviceId = "android-" . $this->guid;
        $json = '{"device_id":"'.$this->deviceId.'","guid":"'.$this->guid.'","username":"'. self::USERNAME.'","password":"'.self::PASSWORD.'","Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"}';
        $sig = $this->generateSignature($json);
        $options['postData'] = 'signed_body='.$sig.'.'.urlencode($json).'&ig_sig_key_version=6';
        $options['post'] = true;
        $options['cookies'] = false;
        $myid = $this->request->request('accounts/login/', $options);
        $decode = json_decode($myid[1], true);
        $this->uid = $decode['logged_in_user']['pk'];
    }

    /**
     * Search instagram photos by tag
     * @param $tag string
     * @return array Found photos
     */
    public function getPhotosByTag($tag)
    {
        $data = '{"device_id":"'.$this->deviceId.'","guid":"'. $this->guid .'","timezone_offset":"43200","uid":"'.$this->uid.'","q":"'.$tag.'","count":"500","source_type":"5","filter_type":"0","extra":"{}","Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"}';
        $sig = $this->generateSignature($data);
        $options['postData'] = 'signed_body='.$sig.'.'.urlencode($data).'&ig_sig_key_version=6';
        $options['post'] = true;
        $options['cookies'] = true;
        return $this->request->request('feed/tag/'.$tag.'/', $options);
    }
}