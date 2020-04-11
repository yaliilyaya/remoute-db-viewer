<?php

namespace App\Entity;

use App\Collection\ColumnCollection;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Table as TableInfo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Table
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\TableRepository")
 */
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
     * @var ColumnCollection
     */
    private $columns;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @var string|null
     */
    private $label;
    /**
     * @ORM\Column(type="string", length=50)
     * @var string|null
     */
    private $name;
    /**
     * @ORM\Column(type="string", length=255)
     * @var string|null
     */
    private $description;
    /**
     * @ORM\Column(type="boolean", options={"default": "TRUE"})
     * @var boolean
     */
    private $isActive;


    public function __construct()
    {
        $this->columns = new ColumnCollection();
    }

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
     * @return ColumnCollection
     */
    public function getColumns(): ColumnCollection
    {
        return $this->columns;
    }

    /**
     * @param ColumnCollection $columns
     * @return Table
     */
    public function setColumns(ColumnCollection $columns): Table
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