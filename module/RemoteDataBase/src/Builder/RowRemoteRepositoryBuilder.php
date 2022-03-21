<?php

namespace RemoteDataBase\Builder;

use App\Entity\DataBaseInfo;
use App\Entity\TableInfo;
use RemoteDataBase\Exception\ConnectionException;
use RemoteDataBase\Factory\ConnectionBuilder;
use RemoteDataBase\Repository\RowRemoteRepository;
use RemoteDataBase\Repository\TableRemoteRepository;

class RowRemoteRepositoryBuilder
{
    /**
     * @var ConnectionBuilder
     */
    private $connectionBuilder;

    public function __construct(
        ConnectionBuilder $connectionBuilder
    ) {
        $this->connectionBuilder = $connectionBuilder;
    }

    /**
     * @param TableInfo $tableInfo
     * @return RowRemoteRepository
     * @throws ConnectionException
     */
    public function create(TableInfo $tableInfo): RowRemoteRepository
    {
        $connection = $this->connectionBuilder->createConnection($tableInfo->getDataBase());

        return new RowRemoteRepository(
            $connection,
            $tableInfo->getName()
        );
    }
}