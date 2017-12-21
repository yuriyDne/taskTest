<?php

namespace lib;

abstract class AbstractRepository
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @var string
     */
    protected $tableName;

    /**
     * AbstractRepository constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        if (empty($this->tableName)) {
            throw new \LogicException('Table name isn\'t specify for '.get_class($this));
        }
    }

    protected function doGetById($id)
    {
        $command = $this->pdo->prepare("SELECT * FROM {$this->tableName} WHERE id = :id LIMIT 1");
        $command->bindParam(':id', $id, \PDO::PARAM_INT);
        if ($command->execute()) {
            $row = $command->fetch(\PDO::FETCH_ASSOC);
        } else {
            $row = [];
        }

        return $row;
    }

    /**
     * @param array $fields
     * @return int
     */
    protected function doInsert(array $fields)
    {
        $keySql = '`'. implode('`,`', array_keys($fields)).'`';
        $valuesSql = implode(',', $this->getQuotedValues($fields));

        $sql = "INSERT INTO {$this->tableName} ($keySql) VALUES ($valuesSql)";
        $this->pdo->prepare($sql)->execute();

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * @param int $id
     * @param array $fields
     * @param string $pkName
     * @return bool
     */
    protected function doUpdate($id, array $fields, $pkName = 'id')
    {
        if (empty($fields)) {
            return false;
        }
        $updatedFieldsSql = $this->getParamsSql($fields, ' , ');
        $sql = "UPDATE {$this->tableName} SET $updatedFieldsSql WHERE {$pkName} = $id";
        $this->pdo->prepare($sql)->execute();
    }

    protected function doFind(
        array $attributes = []
    ) {
        $result = $this->doFindAll($attributes, null, 0, 1);
        return (!empty($result))
            ? reset($result)
            : null;
    }

    protected function doFindAll(
        array $attributes = [],
        $order = null,
        $offset = null,
        $limit = null
    ) {
        $paramsSql = !empty($attributes)
            ? $this->getParamsSql($attributes, ' AND ')
            : '1=1';
        $sql = "SELECT * FROM {$this->tableName} WHERE $paramsSql";
        if ($order) {
            $sql.= ' ORDER BY '.$order;
        }
        if (!is_null($offset)
            && !is_null($limit)
        ) {
            $sql.= " LIMIT $offset, $limit";
        }

        $command = $this->pdo->prepare($sql);
        $command->execute();
        return $command->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $sql
     * @return array
     */
    protected function findAllBySql($sql)
    {
        $command = $this->pdo->prepare($sql);
        $command->execute();
        return $command->fetchAll(\PDO::FETCH_ASSOC);
    }

    protected function doCount(array $attributes = [])
    {
        $paramsSql = !empty($attributes)
            ? $this->getParamsSql($attributes, ' AND ')
            : '1=1';
        $sql = "SELECT count(*) FROM {$this->tableName} WHERE  $paramsSql";
        $command = $this->pdo->prepare($sql);
        $command->execute();
        return $command->fetchColumn();
    }

    private function getParamsSql(array $fields, $separator)
    {
        $result = [];
        foreach ($fields as $key => $value) {
            $result[] = "`$key` = ".$this->getQuotedValue($value);
        }

        return implode($separator, $result);
    }

    private function getQuotedValues(array $values)
    {
        $result = [];

        foreach ($values as $value) {
            $result[] = $this->getQuotedValue($value);
        }

        return $result;
    }

    private function getQuotedValue($value)
    {
        if (is_numeric($value)) {
            return $value;
        } else {
            return $this->pdo->quote($value);
        }
    }
}