<?php


namespace App\Service\ImportExport;


use App\Entity\ColumnDecorator;
use App\Entity\RemoteRelative;
use App\Entity\RemoteTable;
use App\Entity\RemoteTableColumn;
use App\Repository\RemoteTableColumnRepository;

/**
 * Class TableExtractDataService
 * @package App\Service\ImportExport
 */
class ColumnImportService
{
    /**
     * @var RemoteTableColumnRepository
     */
    private $remoteTableColumnRepository;

    public function __construct(RemoteTableColumnRepository $remoteTableColumnRepository)
    {
        $this->remoteTableColumnRepository = $remoteTableColumnRepository;
    }

    public function columnImport(array $columnsData)
    {
        $columns = $this->remoteTableColumnRepository->findColumns([]);

        foreach ($columnsData as $columnData)
        {
            $column = $columns->findById($columnData['id']);
            $column->setDescription($columnData['description']);
            $column->setIsActive($columnData['isActive']);
        }
    }
}