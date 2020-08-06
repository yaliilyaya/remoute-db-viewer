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
     * @Route("/list/{db}/{tableName}", name="list")
     * @param $db
     * @param $tableName
     * @return Response
     * @throws DBALException
     */
    public function listByName($db, $tableName): Response
    {
        $table = $this->remoteTableRepository->findByTableFullName($db, $tableName);
        if (!$table)
        {
            throw $this->createNotFoundException('The table does not exist');
        }

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
     * @Route("/list/{tableId}", name="listById")
     * @param $tableId
     * @return Response
     */
    public function list($tableId): Response
    {
        $table = $this->remoteTableRepository->find($tableId);

        return $this->redirectToRoute('listByName', [
            'db' => $table->getDatabase()->getAlias(),
            'tableName' => $table->getName()
        ]);
    }
}