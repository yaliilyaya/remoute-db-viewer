<?php


namespace App\Builder;


use App\Entity\DataBaseInfo;
use App\Entity\TableInfo;
use App\Factory\ConnectionFactory;
use App\Model\DelayedConnection;

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
     * @param DataBaseInfo $db
     * @param TableInfo $table
     * @return DelayedConnection
     */
    public function create(DataBaseInfo $db, TableInfo $table) :DelayedConnection
    {
        return new DelayedConnection($db,
            $table,
            $this->connectionFactory,
            $this->columnCollectionByTableBuilder);
    }

}