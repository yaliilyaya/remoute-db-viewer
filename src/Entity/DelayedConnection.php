<?php


namespace App\Entity;


use App\Builder\ColumnCollectionByTableBuilder;
use App\Collection\ColumnCollection;
use App\Factory\ConnectionFactoryInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\Table;

class DelayedConnection
{

    /**
     * @var RemoteDataBase
     */
    private $db;
    /**
     * @var RemoteTable
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
        RemoteDataBase $db,
        RemoteTable $table,
        ConnectionFactoryInterface $connectionFactory,
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
     * @return ColumnCollection
     * @throws DBALException
     */
    public function getColumns() :ColumnCollection
    {
        return $this->columnCollectionByTableBuilder->create($this->table);
    }


}