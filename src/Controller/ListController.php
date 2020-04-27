<?php

namespace App\Controller;

use App\Factory\ConnectionByDataBaseFactory;
use App\Factory\ConnectionFactory;
use App\Repository\RemoteTableRepository;
use App\Service\DataListTableService;
use App\Service\RemoteTableInfoService;
use App\Service\TableView\ViewColumnsTableListService;
use Doctrine\DBAL\DBALException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ListController
 * @package App\Controller
 */
class ListController extends AbstractController
{
    /**
     * @var RemoteTableInfoService
     */
    private $dynamicTableInfoService;
    /**
     * @var DataListTableService
     */
    private $dataListTableService;
    /**
     * @var ViewColumnsTableListService
     */
    private $viewColumnsTableListService;
    /**
     * @var ConnectionFactory
     */
    private $connectionFactory;
    /**
     * @var RemoteTableRepository
     */
    private $remoteTableRepository;
    /**
     * @var ConnectionByDataBaseFactory
     */
    private $connectionByDataBaseFactory;

    public function __construct(
        RemoteTableInfoService $dynamicTableInfoService,
        DataListTableService $dataListTableService,
        ViewColumnsTableListService $viewColumnsTableListService,
        ConnectionFactory $connectionFactory,
        RemoteTableRepository $remoteTableRepository,
        ConnectionByDataBaseFactory $connectionByDataBaseFactory
    ) {
        $this->dynamicTableInfoService = $dynamicTableInfoService;
        $this->dataListTableService = $dataListTableService;
        $this->viewColumnsTableListService = $viewColumnsTableListService;
        $this->connectionFactory = $connectionFactory;
        $this->remoteTableRepository = $remoteTableRepository;
        $this->connectionByDataBaseFactory = $connectionByDataBaseFactory;
    }

    /**
     * @Route("/list/{db}/{tableName}", name="listByName")
     * @param $db
     * @param $tableName
     * @return Response
     * @throws DBALException
     */
    public function listByName($db, $tableName)
    {
        $connection = $this->connectionFactory->createConnection($db);
        $table = $this->dynamicTableInfoService->getTableInfo($connection, $tableName);

        $rows = $this->dataListTableService->getRows($table);
        $columns = $this->viewColumnsTableListService->getColumns($table);
        $table = $columns->count() ? $columns->current()->getTable() : null;//TODO нужно доделать

        return $this->render('table/list.html.twig', [
            'rows' => $rows,
            'table' => $table,
            'columns' => $columns
        ]);
    }

    /**
     * @Route("/list/{tableId}", name="list")
     * @param $tableId
     * @return Response
     * @throws DBALException
     */
    public function list($tableId)
    {
        $table = $this->remoteTableRepository->find($tableId);

        $connection = $this->connectionByDataBaseFactory->createConnection($table->getDatabase());
        $table->setConnection($connection);

        $rows = $this->dataListTableService->getRows($table);

        return $this->render('table/list.html.twig', [
            'rows' => $rows,
            'table' => $table,
            'columns' => $table->getColumns()
        ]);
    }
}