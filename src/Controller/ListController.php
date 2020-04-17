<?php

namespace App\Controller;

use App\Factory\ConnectionFactory;
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

    public function __construct(
        RemoteTableInfoService $dynamicTableInfoService,
        DataListTableService $dataListTableService,
        ViewColumnsTableListService $viewColumnsTableListService,
        ConnectionFactory $connectionFactory
    ) {
        $this->dynamicTableInfoService = $dynamicTableInfoService;
        $this->dataListTableService = $dataListTableService;
        $this->viewColumnsTableListService = $viewColumnsTableListService;
        $this->connectionFactory = $connectionFactory;
    }

    /**
     * @Route("/list/{db}/{tableName}", name="list")
     * @param $db
     * @param $tableName
     * @return Response
     * @throws DBALException
     */
    public function list($db, $tableName)
    {
        $connection = $this->connectionFactory->createConnection($db);
        $table = $this->dynamicTableInfoService->getTableInfo($connection, $tableName);

        $rows = $this->dataListTableService->getRows($table);
        $columns = $this->viewColumnsTableListService->getColumns($table);

        return $this->render('table/list.html.twig', [
            'rows' => $rows,
            'columns' => $columns
        ]);
    }
}