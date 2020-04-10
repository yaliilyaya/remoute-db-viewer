<?php

namespace App\Controller;

use App\Service\DataListTableService;
use App\Service\DynamicTableInfoService;
use App\Service\TableView\ViewColumnsTableListService;
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
     * @var DynamicTableInfoService
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

    public function __construct(
        DynamicTableInfoService $dynamicTableInfoService,
        DataListTableService $dataListTableService,
        ViewColumnsTableListService $viewColumnsTableListService
    ) {
        $this->dynamicTableInfoService = $dynamicTableInfoService;
        $this->dataListTableService = $dataListTableService;
        $this->viewColumnsTableListService = $viewColumnsTableListService;
    }

    /**
     * @Route("/list/{db}/{tableName}")
     * @param $db
     * @param $tableName
     * @return Response
     */
    public function list($db, $tableName)
    {
        $table = $this->dynamicTableInfoService->getTableInfo($db, $tableName);
        $rows = $this->dataListTableService->getRows($table);
        $columns = $this->viewColumnsTableListService->getColumns($table);

        return $this->render('table/list.html.twig', [
            'rows' => $rows,
            'columns' => $columns
        ]);
    }
}