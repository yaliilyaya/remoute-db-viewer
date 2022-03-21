<?php
namespace RemoteDataBase\Builder;

use App\Entity\DataBaseInfo;
use Doctrine\DBAL\Connection;
use RemoteDataBase\Exception\ConnectionException;
use RemoteDataBase\Factory\ConnectionBuilder;
use RemoteDataBase\Repository\ColumnRemoteRepository;
use RemoteDataBase\Repository\DataBaseRemoteRepository;

class DataBaseRemoteRepositoryBuilder
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
     * @return DataBaseRemoteRepository
     * @throws ConnectionException
     */
    public function create(DataBaseInfo $dataBase): DataBaseRemoteRepository
    {
        $connection = $this->connectionBuilder->createConnection($dataBase);

        return new DataBaseRemoteRepository(
            $connection
        );
    }

}