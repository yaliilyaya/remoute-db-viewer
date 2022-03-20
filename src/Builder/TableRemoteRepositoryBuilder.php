<?php

namespace App\Builder;

use App\Entity\DataBaseInfo;
use App\Exception\ConnectionException;
use App\Factory\ConnectionBuilder;
use App\Repository\TableRemoteRepository;

class TableRemoteRepositoryBuilder
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
     * @param DataBaseInfo $dataBase
     * @return TableRemoteRepository
     * @throws ConnectionException
     */
    public function create(DataBaseInfo $dataBase): TableRemoteRepository
    {
        $connection = $this->connectionBuilder->createConnection($dataBase);

        return new TableRemoteRepository(
            $connection
        );
    }
}