<?php

namespace Repository;

use Dto\LinkStatisticDto;
use lib\AbstractRepository;

class LinkStatisticRepository extends AbstractRepository
{
    protected $tableName = 'link_statistic';

    /**
     * @param LinkStatisticDto $item
     * @return LinkStatisticDto
     */
    public function save(LinkStatisticDto $item)
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
     * @return LinkStatisticDto
     */
    private function arrayToDto(array $rawData)
    {
        return new LinkStatisticDto(
            (int) $rawData['id'],
            $rawData['link_id'],
            new \DateTimeImmutable($rawData['created_at']),
            $rawData['ip'],
            $rawData['location'],
            $rawData['browser_name'],
            $rawData['browser_version'],
            $rawData['operation_system']
        );
    }

    /**
     * @param LinkStatisticDto $item
     * @return array
     */
    private function dtoToArray(LinkStatisticDto $item)
    {
        return [
            'id' => $item->getId(),
            'link_id' => $item->getLinkId(),
            'created_at' => $item->getDate()->format('Y-m-d H:i:s'),
            'created_date' => $item->getDate()->format('Y-m-d H:i:s'),
            'ip' => $item->getIp(),
            'location' => $item->getLocation(),
            'browser_name' => $item->getBrowserName(),
            'browser_version' => $item->getBrowserVersion(),
            'operation_system' => $item->getOperationSystem(),
        ];
    }

    /**
     * @param int $linkId
     * @param \DateTimeImmutable $startDate
     * @param \DateTimeImmutable $endDate
     * @return array
     */
    public function getGroupedData(
        $linkId,
        \DateTimeImmutable $startDate,
        \DateTimeImmutable $endDate
    ) {
        $sql = sprintf("
            SELECT created_date, count(created_date) as views_count 
            FROM {$this->tableName} 
            WHERE created_date BETWEEN '%s' and '%s'
              AND link_id = %d
              GROUP BY created_date
              ORDER BY created_date desc
        ", $startDate->format('Y-m-d'), $endDate->format('Y-m-d'), $linkId);

        return $this->findAllBySql($sql);
    }

    public function getDailyData($linkId, \DateTimeImmutable $date)
    {
        $rawData = $this->doFindAll(
            [
                'link_id' => (int) $linkId,
                'created_date' => $date->format('Y-m-d')
            ],
            'id desc'
        );

        $result = [];
        if (!empty($rawData)) {
            foreach ($rawData as $item) {
                $result[] = $this->arrayToDto($item);
            }
        }

        return $result;
    }

}