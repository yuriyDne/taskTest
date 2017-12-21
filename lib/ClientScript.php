<?php

namespace lib;

use lib\Exception\FileNotFoundException;

class ClientScript
{
    /**
     * @var array
     */
    private $jsScripts = [];

    /**
     * @var array
     */
    private $cssScripts = [];

    /**
     * @return array
     */
    public function getJsScripts()
    {
        return array_values($this->jsScripts);
    }

    /**
     * @return array
     */
    public function getCssScripts()
    {
        return array_values($this->cssScripts);
    }


    public function registerCssFile(
        $relativePath
    ) {
        $relativePath = "css/{$relativePath}.css";
        $this->assertFileExists($relativePath);
        $this->cssScripts[$relativePath] = "/mvc/$relativePath";
    }

    /**
     * @param $relativePath
     */
    public function registerJsFile(
        $relativePath
    ) {
        $relativePath = "js/{$relativePath}.js";
        $this->assertFileExists($relativePath);
        $this->cssScripts[$relativePath] = "/mvc/$relativePath";
    }


    private function assertFileExists($relativeFile)
    {
        if (!is_file(MVC_PATH.$relativeFile)) {
            throw new FileNotFoundException(MVC_PATH.$relativeFile);
        }
    }

    /**
     * @param string $url
     */
    public function addExternalJsScript($url)
    {
        if (!isset($this->jsScripts[$url])) {
            $this->jsScripts[$url] = $url;
        }
    }

    /**
     * @param string $url
     */
    public function addExternalCssScript($url)
    {
        if (!isset($this->cssScripts[$url])) {
            $this->cssScripts[$url] = $url;
        }
    }

}