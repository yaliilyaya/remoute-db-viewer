<?php

namespace App\Controller;

use App\Repository\TableInfoRepository;
use App\Service\DataListTableService;
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
     * @var DataListTableService
     */
    private $dataListTableService;
    /**
     * @var ViewColumnsTableListService
     */
    private $viewColumnsTableListService;
    /**
     * @var TableInfoRepository
     */
    private $remoteTableRepository;

    public function __construct(
        DataListTableService $dataListTableService,
        ViewColumnsTableListService $viewColumnsTableListService,
        TableInfoRepository $remoteTableRepository
    ) {
        $this->dataListTableService = $dataListTableService;
        $this->viewColumnsTableListService = $viewColumnsTableListService;
        $this->remoteTableRepository = $remoteTableRepository;
    }

    /**
     * @Route("/info/{db}/{tableName}", name="list")
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

        $filter = $_GET['filter'] ?? null;
        $filter = is_string($filter) ? json_decode($filter, true) : $filter;

        $rows = $this->dataListTableService->getRows($table, $filter ?: []);
        $columns = $this->viewColumnsTableListService->getColumns($table);

        $table = $columns->count() ? $columns->current()->getTable() : null;//TODO нужно доделать

        return $this->render('table/list.html.twig', [
            'rows' => $rows,
            'table' => $table,
            'columns' => $columns,
            'filter' => $filter
        ]);
    }

    /**
     * @Route("/info/{tableId}", name="listById")
     * @param $tableId
     * @return Response
     */
    public function list($tableId): Response
    {
        $table = $this->remoteTableRepository->find($tableId);

        return $this->redirectToRoute('list', [
            'db' => $table->getDataBase()->getAlias(),
            'tableName' => $table->getName()
        ]);
    }
}