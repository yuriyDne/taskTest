<?php

namespace Controller;

use lib\AbstractController;
use mvc\Service\LinkShorter;

class StatisticController extends AbstractController
{
    public function grouped($hash, $startDate = null, $endDate = null)
    {
        $startDate = !empty($startDate) ? new \DateTimeImmutable($startDate) : new \DateTimeImmutable('-1 month');
        $endDate = !empty($endDate) ? new \DateTimeImmutable($endDate) : new \DateTimeImmutable();

        $linkShorter = new LinkShorter();
        $linkId = $linkShorter->getIdByUrlStub($hash);

        $viewData = $this->getRepositoryManager()->getLinkStatisticRepository()->getGroupedData(
            $linkId,
            $startDate,
            $endDate
        );

        $link = $this->getRepositoryManager()->getLinkShorterRepository()->getById($linkId);
        $this->view->withParam('viewData', $viewData)
            ->withParam('link', $link)
            ->withParam('linkUrl', $linkShorter->getStatisticAddress($link))
            ->render('statistic/grouped');
    }

    public function daily($hash, $date)
    {
        $date = new \DateTimeImmutable($date);
        $linkShorter = new LinkShorter();
        $linkId = $linkShorter->getIdByUrlStub($hash);
        $link = $this->getRepositoryManager()->getLinkShorterRepository()->getById($linkId);

        $viewData = $this->getRepositoryManager()->getLinkStatisticRepository()->getDailyData($linkId, $date);

        $this->view->withParam('viewData', $viewData)
            ->withParam('backUrl', $linkShorter->getStatisticAddress($link))
            ->withParam('link', $link)
            ->render('statistic/daily');
    }
}