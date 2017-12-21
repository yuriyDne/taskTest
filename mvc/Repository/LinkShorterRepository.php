<?php

namespace Repository;

use Dto\LinkShorterDto;
use lib\AbstractRepository;
use mvc\Exception\NoEntityFoundException;

class LinkShorterRepository extends AbstractRepository
{
    protected $tableName = 'link_entity';

    /**
     * @param LinkShorterDto $item
     * @return LinkShorterDto
     */
    public function save(LinkShorterDto $item)
    {
        if ($item->getId()) {
            $this->doUpdate(
                $item->getId(),
                $this->dtoToArray($item)
            );
        } else {
            $attributes = $this->dtoToArray($item);
            unset($attributes['id']);
            $id = $this->doInsert($attributes);
            $item->setId($id);
        }

        return $item;
    }

    /**
     * @param array $rawData
     * @return LinkShorterDto
     */
    private function arrayToDto(array $rawData)
    {
        return new LinkShorterDto(
            (int) $rawData['id'],
            $rawData['link'],
            $rawData['hash']
        );
    }

    /**
     * @param LinkShorterDto $item
     * @return array
     */
    private function dtoToArray(LinkShorterDto $item)
    {
        return [
            'id' => $item->getId(),
            'hash' => $item->getHash(),
            'link' => $item->getLink()
        ];
    }

    /**
     * @param int $id
     * @return LinkShorterDto
     */
    public function getById($id)
    {
        $result = null;

        $rawData = $this->doGetById($id);
        if (empty($rawData)) {
            throw new NoEntityFoundException(__CLASS__.':'.$id);
        }

        return $this->arrayToDto($rawData);
    }

    public function findByHash($hash)
    {
        $result = null;

        $rawData = $this->doFind(['hash' => $hash]);
        return !empty($rawData) ? $this->arrayToDto($rawData) : null;
    }
}