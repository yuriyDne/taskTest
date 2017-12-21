<?php
namespace Controller;

use Dto\LinkShorterDto;
use Dto\LinkStatisticDto;
use lib\AbstractController;
use mvc\Service\LinkShorter;
use mvc\Service\UserInfo;

class LinkController extends AbstractController
{
    /**
     * @param $hash
     */
    public function show($hash)
    {
        $linkShorter = new LinkShorter();
        $linkId = $linkShorter->getIdByUrlStub($hash);

        $repository = $this->getRepositoryManager()->getLinkShorterRepository();


        $item = $repository->getById($linkId);
        $userInfo = new UserInfo();

        $statisticDto = new LinkStatisticDto(
            null,
            $item->getId(),
            new \DateTimeImmutable(),
            $userInfo->getIp(),
            $userInfo->getLocation(),
            $userInfo->getBrowserName(),
            $userInfo->getBrowserVersion(),
            $userInfo->getOperatingSystemName()
        );

        $this->getRepositoryManager()->getLinkStatisticRepository()->save($statisticDto);

        $this->request->redirect($item->getLink());
    }

    public function add($url = null)
    {
        $errorMessage = '';
        $resultLinks = [];
        if ($this->request->isPostRequest()) {
            if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
                $errorMessage = 'Url is not valid';
            } else {
                $linkRepository = $this->getRepositoryManager()->getLinkShorterRepository();
                $linkHash = md5($url);
                $link = $linkRepository->findByHash(
                    $linkHash
                );

                if (is_null($link)) {
                    $link = new LinkShorterDto(
                        null,
                        $url,
                        $linkHash
                    );
                    $link = $linkRepository->save($link);
                }

                $linkShorter = new LinkShorter();
                $resultLinks = [
                    'Your view url' => $linkShorter->getViewAddress($link),
                    'Your statistic url' => $linkShorter->getStatisticAddress($link)
                ];
            }
        }

        $this->view->withParam('errorMessage', $errorMessage)
            ->withParam('resultLinks', $resultLinks)
            ->withParam('url', $url)
            ->render('link/add');
    }


    public function statisticAll($startDate = null, $endDate = null)
    {

    }


}