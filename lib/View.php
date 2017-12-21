<?php

namespace lib;

use lib\Exception\FileNotFoundException;

class View
{
    /**
     * @var string
     */
    private $layout = 'default';
    /**
     * @var array
     */
    private $params = [];

    /**
     * @var string
     */
    private $viewPath = MVC_PATH.'views/';
    /**
     * @var ClientScript
     */
    private $clientScript;

    /**
     * View constructor.
     * @param ClientScript $clientScript
     */
    public function __construct(
        ClientScript $clientScript
    ) {
        $this->clientScript = $clientScript;
    }

    /**
     * @param string $layout
     * @return $this
     */
    public function withLayout($layout)
    {
        $this->layout = $layout;
        return $this;
    }


    /**
     * @param string $paramName
     * @param $paramValue
     * @return $this
     */
    public function withParam($paramName, $paramValue)
    {
        $this->params[$paramName] = $paramValue;
        return $this;
    }

    public function render($viewName)
    {
        $viewContent = $this->getContent($viewName, $this->params);

        $layoutPath = 'layout'.DS.$this->layout;
        $this->withParam('viewContent', $viewContent)
            ->withParam('jsScripts', $this->clientScript->getJsScripts())
            ->withParam('cssScripts', $this->clientScript->getCssScripts())
            ->renderPartial($layoutPath, $this->params);
    }


    public function renderPartial($viewName, array $params = []) {
        $viewPath = $this->viewPath. $viewName. '.php';

        if (!file_exists($viewPath)) {
            throw new FileNotFoundException($viewPath);
        }

        foreach ($params as $key => $value) {
            $$key = $value;
        }

        include $viewPath;
    }

    /**
     * @param $data
     */
    public function renderJson($data) {
        header('Content-type:application/json;charset=utf-8');
        echo json_encode($data);
    }

    /**
     * @param string $viewName
     * @param array $params
     * @return string
     */
    public function getContent($viewName, array $params)
    {
        ob_start();
        ob_implicit_flush(false);
        $this->renderPartial($viewName, $params);
        return ob_get_clean();
    }
}