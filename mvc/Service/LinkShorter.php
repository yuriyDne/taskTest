<?php

namespace mvc\Service;

use Dto\LinkShorterDto;
use lib\Request;

class LinkShorter
{
    const STATISTIC_CHARACTER = 's';

    public function getIdByUrlStub($urlStub)
    {
        $hash = str_replace('/', '', $urlStub);
        if ($this->isStatisticMode($urlStub)) {
            $hash = substr($hash, 0, strlen($hash) -1);
        }
        $hashAttributes = explode('-', $hash);

        return $hashAttributes[1];
    }

    public function getViewAddress(LinkShorterDto $link)
    {
        $request = new Request();
        return $request->getAbsoluteUrl('h-'.$link->getId());
    }

    public function getStatisticAddress(LinkShorterDto $link)
    {
        return $this->getViewAddress($link).self::STATISTIC_CHARACTER;
    }

    public function isStatisticMode($urlStub)
    {
        $lastCharacter = substr($urlStub, -1);
        return $lastCharacter == 's';
    }

}