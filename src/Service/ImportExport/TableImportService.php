<?php


namespace App\Service\ImportExport;


use App\Entity\ColumnDecorator;
use App\Entity\RemoteRelative;
use App\Entity\RemoteTable;
use App\Entity\RemoteTableColumn;
use App\Repository\RemoteTableRepository;

/**
 * Class TableExtractDataService
 * @package App\Service\ImportExport
 */
class TableImportService
{
    /**
     * @var RemoteTableRepository
     */
    private $remoteTableRepository;

    public function __construct(
        RemoteTableRepository $remoteTableRepository
    ) {
        $this->remoteTableRepository = $remoteTableRepository;
    }

    public function tableImport(array $tablesData)
    {
        $tables = $this->remoteTableRepository->findTables([]);

        foreach ($tablesData as $tableData)
        {
            $table = $tables->findById($tableData['id']);
            $table->setDescription($tableData['description']);
            $table->setIsActive($tableData['isActive']);
        }
    }
}