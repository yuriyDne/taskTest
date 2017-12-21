<?php

namespace mvc\Service;

use BrowscapPHP\Browscap;

class UserInfo
{
    /**
     * @var array
     */
    private $browserInfo;

    /**
     * @var
     */
    private $ip;

    public function __construct()
    {
        $browscap = new Browscap();
        $this->browserInfo = $browscap->getBrowser();
        $this->geoIp = []; //geoip_record_by_name($this->getIp());
    }

    public function getIp()
    {
        if (is_null($this->ip)) {
            if (!empty($_SERVER['REMOTE_ADDR'])) {
                $this->ip = $_SERVER['REMOTE_ADDR'];
            } elseif (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
                $this->ip = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $this->ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else $this->ip = "0.0.0.0";

        }

        return $this->ip;
    }

    public function getLocation()
    {
        return '';
    }

    public function getBrowserName()
    {
        return $this->browserInfo->browser;
    }

    public function getBrowserVersion()
    {
        return $this->browserInfo->version;
    }

    public function getOperatingSystemName()
    {
        return $this->browserInfo->platform;
    }
}