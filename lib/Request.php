<?php
/**
 * Created by PhpStorm.
 * User: yuriy
 * Date: 11/14/17
 * Time: 3:57 PM
 */

namespace lib;


use config\Constants;

class Request
{
    /**
     * @return string
     */
    public function getRequestUri()
    {
        return Constants::SITE_SCHEMA. "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    }

    /**
     * @param $url
     * @return string
     */
    public function getAbsoluteUrl($url)
    {
        return Constants::SITE_SCHEMA. "://{$_SERVER['HTTP_HOST']}/{$url}";
    }

    /**
     * @param string $variableName
     * @param null|mixed $defaultValue
     * @return mixed
     */
    public function get($variableName, $defaultValue = null)
    {
        return urldecode($this->getFromArray($_GET, $variableName, $defaultValue));
    }

    /**
     * @param string $variableName
     * @param null|mixed $defaultValue
     * @return mixed
     */
    public function post($variableName, $defaultValue = null)
    {
        return $this->getFromArray($_POST, $variableName, $defaultValue);
    }

    /**
     * @param string $variableName
     * @param null|mixed $defaultValue
     * @return mixed
     */
    public function postOrGet($variableName, $defaultValue = null)
    {
        $defaultValue = $this->get($variableName, $defaultValue);
        return $this->post($variableName, $defaultValue);
    }

    public function redirect(
        $url,
        $statusCode = 303
    ) {
        header('Location: '.$url, true, $statusCode);
        die();
    }

    /**
     * @return bool
     */
    public function isPostRequest()
    {
        return isset($_SERVER['REQUEST_METHOD']) && !strcasecmp($_SERVER['REQUEST_METHOD'], 'POST');
    }

    /**
     * @param array $array
     * @param string $variableName
     * @param mixed $defaultValue
     * @return mixed
     */
    private function getFromArray(array $array, $variableName, $defaultValue)
    {
        if (!is_string($variableName)) {
            throw new \InvalidArgumentException('variableName must be string');
        }

        if (!isset($array[$variableName])) {
            return $defaultValue;
        }

        return $array[$variableName];
    }
}