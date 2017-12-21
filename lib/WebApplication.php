<?php
/**
 * Created by PhpStorm.
 * User: yuriy
 * Date: 11/14/17
 * Time: 3:34 PM
 */

namespace lib;


use Controller\LinkController;
use Controller\StatisticController;
use mvc\Service\LinkShorter;

class WebApplication
{
    /**
     * @var Request
     */
    private $request;

    public function run()
    {
        $this->request = new Request();
        $controller = $this->getController();
        $controller->runAction();
    }

    private function getController()
    {
        $hash = $this->request->get('hash');
        if (empty($hash)) {
            $controller = $this->buildController(LinkController::class, 'add');
        } else {
            $linkShorter = new LinkShorter();
            if (!$linkShorter->isStatisticMode($hash)) {
                $controller = $this->buildController(LinkController::class, 'show');
            } else {
                $actionName = $this->request->get('date') ? 'daily' : 'grouped';
                $controller = $this->buildController(StatisticController::class, $actionName);
            }
        }

        return $controller;
    }

    private function buildController($controllerClass, $actionName)
    {
        $clientScript = new ClientScript();
        return new $controllerClass(
            new View($clientScript),
            $this->request,
            $clientScript,
            $actionName
        );
    }
}