<?php

namespace Dto;

class LinkStatisticDto
{
    /**
     * @var \DateTimeImmutable
     */
    private $date;
    /**
     * @var string
     */
    private $ip;
    /**
     * @var string
     */
    private $location;
    /**
     * @var string
     */
    private $browserName;
    /**
     * @var string
     */
    private $browserVersion;
    /**
     * @var string
     */
    private $operationSystem;
    /**
     * @var null
     */
    private $id;
    private $linkId;

    /**
     * LinkStatisticDto constructor.
     * @param null $id
     * @param $linkId
     * @param \DateTimeImmutable $date
     * @param string $ip
     * @param string $location
     * @param string $browserName
     * @param string $browserVersion
     * @param string $operationSystem
     */
    public function __construct(
        $id = null,
        $linkId,
        \DateTimeImmutable $date,
        $ip,
        $location,
        $browserName,
        $browserVersion,
        $operationSystem
    ) {
        $this->id = $id;
        $this->linkId = $linkId;
        $this->date = $date;
        $this->ip = $ip;
        $this->location = $location;
        $this->browserName = $browserName;
        $this->browserVersion = $browserVersion;
        $this->operationSystem = $operationSystem;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @return string
     */
    public function getBrowserName()
    {
        return $this->browserName;
    }

    /**
     * @return string
     */
    public function getBrowserVersion()
    {
        return $this->browserVersion;
    }

    /**
     * @return string
     */
    public function getOperationSystem()
    {
        return $this->operationSystem;
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getLinkId()
    {
        return $this->linkId;
    }

    /**
     * @param null $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}