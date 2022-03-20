<?php
namespace RemoteDataBase\Builder;

use App\Entity\DataBaseInfo;
use App\Exception\ConnectionException;
use App\Factory\ConnectionBuilder;
use App\Repository\ColumnRemoteRepository;

class ColumnRemoteRepositoryBuilder
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
     * @return ColumnRemoteRepository
     * @throws ConnectionException
     */
    public function create(DataBaseInfo $dataBase): ColumnRemoteRepository
    {
        $connection = $this->connectionBuilder->createConnection($dataBase);

        return new ColumnRemoteRepository(
            $connection
        );
    }
}