<?php
namespace RemoteDataBase\Builder;

use App\Entity\DataBaseInfo;
use RemoteDataBase\Exception\ConnectionException;
use RemoteDataBase\Factory\ConnectionBuilder;
use RemoteDataBase\Repository\ColumnRemoteRepository;

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