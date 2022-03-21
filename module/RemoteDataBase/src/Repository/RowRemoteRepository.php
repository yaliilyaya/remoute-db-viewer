<?php


namespace RemoteDataBase\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Table;

class RowRemoteRepository
{
    /**
     * @var Connection
     */
    private $connection;
    /**
     * @var string
     */
    private $tableName;

    public function __construct(
        Connection $connection,
        string $tableName
    ) {
        $this->connection = $connection;
        $this->tableName = $tableName;
    }

    public function findBy(array $filter, $count = 20)
    {
        $queryBuilder = $this->connection->createQueryBuilder()            ;
        $queryBuilder->select(['*'])
            ->from($this->tableName)
            ->setMaxResults($count);

        if ($filter)
        {
            $filter = is_array($filter) ? $filter : [$filter];
            $queryBuilder->where(array_shift($filter));
            foreach ($filter as $key => $param) {
                $queryBuilder->setParameter($key, $param, is_array($param) ? Connection::PARAM_STR_ARRAY  : null);
            }
        }

        return $queryBuilder->execute()->fetchAll();
    }
}