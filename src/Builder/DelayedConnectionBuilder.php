<?php


namespace App\Builder;


use App\Entity\DelayedConnection;
use App\Entity\RemoteDataBase;
use App\Entity\RemoteTable;
use App\Factory\ConnectionFactory;

class DelayedConnectionBuilder
{
    /**
     * @var ConnectionFactory
     */
    private $connectionFactory;
    /**
     * @var ColumnCollectionByTableBuilder
     */
    private $columnCollectionByTableBuilder;

    public function __construct(
        ColumnCollectionByTableBuilder $columnCollectionByTableBuilder,
        ConnectionFactory $connectionFactory
    ) {
        $this->connectionFactory = $connectionFactory;
        $this->columnCollectionByTableBuilder = $columnCollectionByTableBuilder;
    }

    /**
     * @param RemoteDataBase $db
     * @param RemoteTable $table
     * @return DelayedConnection
     */
    public function create(RemoteDataBase $db, RemoteTable $table) :DelayedConnection
    {
        return new DelayedConnection($db,
            $table,
            $this->connectionFactory,
            $this->columnCollectionByTableBuilder);
    }

}