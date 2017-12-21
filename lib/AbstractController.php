<?php

namespace lib;

use mvc\Service\RepositoryManager;

abstract class AbstractController
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var string
     */
    protected $actionName;
    /**
     * @var View
     */
    protected $view;

    /**
     * @var ClientScript
     */
    protected $clientScript;

    /**
     * @var RepositoryManager
     */
    private $repositoryManager;

    /**
     * ControllerBase constructor.
     * @param View $view
     * @param Request $request
     * @param ClientScript $clientScript
     * @param string $actionName
     */
    public function __construct(
        View $view,
        Request $request,
        ClientScript $clientScript,
        $actionName
    ) {
        $this->request = $request;
        $this->actionName = $actionName;
        $this->view = $view;
        $this->clientScript = $clientScript;
        $this->repositoryManager = new RepositoryManager();

        $this->clientScript->addExternalJsScript('https://code.jquery.com/jquery-3.2.1.min.js');
        $this->clientScript->addExternalJsScript('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js');
        $this->clientScript->addExternalCssScript('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
        $this->clientScript->addExternalJsScript('https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.11/handlebars.js');
    }

    public function runAction()
    {
        $method = new \ReflectionMethod($this, $this->actionName);
        $params = $method->getParameters();
        $paramValues = [];
        foreach ($params as $param) {
            $paramValues[] = $this->request->postOrGet($param->getName());
        }

        $method->invoke($this, ...$paramValues);
    }

    /**
     * @return Request
     */
    protected function getRequest()
    {
        return $this->serviceProvider->getRequest();
    }

    /**
     * @return RepositoryManager
     */
    public function getRepositoryManager()
    {
        return $this->repositoryManager;
    }
}