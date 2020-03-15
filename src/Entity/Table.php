<?php

namespace App\Entity;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Table as TableInfo;

class Table
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var TableInfo
     */
    private $tableInfo;
    /**
     * @var Column[]
     */
    private $columns;

    /**
     * @return Connection
     */
    public function getConnection() : Connection
    {
        return $this->connection;
    }

    /**
     * @param Connection $connection
     * @return Table
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
        return $this;
    }

    /**
     * @return TableInfo
     */
    public function getTableInfo(): TableInfo
    {
        return $this->tableInfo;
    }

    /**
     * @param TableInfo $tableInfo
     * @return Table
     */
    public function setTableInfo(TableInfo $tableInfo): Table
    {
        $this->tableInfo = $tableInfo;
        return $this;
    }

    /**
     * @return Column[]
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @param Column[] $columns
     * @return Table
     */
    public function setColumns(array $columns): Table
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->tableInfo->getName();
    }

    public function getListRowCount()
    {
        return 20;
    }

    public function getFieldSet(string $fieldSet)
    {
        return ['*'];
    }
}