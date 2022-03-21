<?php


namespace App\Service;


use App\Entity\ColumnInfo;
use App\Entity\TableInfo;
use App\Model\RowValue;
use Doctrine\DBAL\DBALException;
use RemoteDataBase\Builder\RowRemoteRepositoryBuilder;

class DetailRowTableService
{
    /**
     * @var RowRemoteRepositoryBuilder
     */
    private $rowRemoteRepositoryBuilder;

    public function __construct(RowRemoteRepositoryBuilder $rowRemoteRepositoryBuilder)
    {
        $this->rowRemoteRepositoryBuilder = $rowRemoteRepositoryBuilder;
    }


    /**
     * @param TableInfo $table
     * @param int $id
     * @return RowValue|null
     */
    public function getRow(TableInfo $table, $id): ?RowValue
    {
        $rowRemoteRepository = $this->rowRemoteRepositoryBuilder->create($table);

        $rows = $rowRemoteRepository->findBy([
            'position_id' => $id
        ]);

        if (!$rows) {
            return null;
        }

        $row = new RowValue();
        $row->setData(current($rows));
        return $row;
    }
}