<?php

namespace mvc\Service;

use config\Constants;
use mvc\Repository\TaskRepository;
use Repository\LinkShorterRepository;
use Repository\LinkStatisticRepository;

class RepositoryManager
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var LinkShorterRepository
     */
    private $linkShorterRepository;

    /**
     * @var LinkStatisticRepository
     */
    private $linkStatisticRepository;

    /**
     * RepositoryManager constructor.
     */
    public function __construct()
    {
        $this->pdo = new \PDO(
            "mysql:host=" . Constants::MYSQL_HOST. ";dbname=" . Constants::MYSQL_DB_NAME. ";charset=utf8",
            Constants::MYSQL_USER,
            Constants::MYSQL_PASSWORD
        );
    }

    /**
     * @return LinkShorterRepository
     */
    public function getLinkShorterRepository()
    {
        if (is_null($this->linkShorterRepository)) {
            $this->linkShorterRepository = new LinkShorterRepository($this->pdo);
        }

        return $this->linkShorterRepository;
    }

    /**
     * @return LinkStatisticRepository
     */
    public function getLinkStatisticRepository()
    {
        if (is_null($this->linkStatisticRepository)) {
            $this->linkStatisticRepository = new LinkStatisticRepository($this->pdo);
        }

        return $this->linkStatisticRepository;
    }
}