<?php


namespace App\Model;


use App\Builder\ColumnCollectionByTableBuilder;
use App\Collection\ColumnInfoCollection;
use App\Entity\DataBaseInfo;
use App\Entity\TableInfo;
use App\Factory\ConnectionFactoryInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\Table;

class DelayedConnection
{

    /**
     * @var DataBaseInfo
     */
    private $db;
    /**
     * @var TableInfo
     */
    private $table;
    /**
     * @var 
     */
    private $connection;

    /**
     * @var ConnectionFactoryInterface
     */
    private $connectionFactory;
    /**
     * @var Table
     */
    private $tableInfo;
    /**
     * @var ColumnCollectionByTableBuilder
     */
    private $columnCollectionByTableBuilder;

    public function __construct(
        DataBaseInfo                   $db,
        TableInfo                      $table,
        ConnectionFactoryInterface     $connectionFactory,
        ColumnCollectionByTableBuilder $columnCollectionByTableBuilder
    ) {
        $this->db = $db;
        $this->table = $table;
        $this->connectionFactory = $connectionFactory;
        $this->columnCollectionByTableBuilder = $columnCollectionByTableBuilder;
    }

    /**
     * @return Connection
     * @throws DBALException
     */
    public function getConnection() :Connection
    {
        return $this->connection ?? $this->connection = $this->connectionFactory->createConnection($this->db->getAlias());
    }

    /**
     * @return Table
     * @throws DBALException
     */
    public function getTableInfo() :Table
    {
        return $this->tableInfo ?? $this->tableInfo = $this->getConnection()->getSchemaManager()->listTableDetails($this->table->getName());
    }

    /**
     * @return ColumnInfoCollection
     * @throws DBALException
     */
    public function getColumns() :ColumnInfoCollection
    {
        return $this->columnCollectionByTableBuilder->create($this->table);
    }


}