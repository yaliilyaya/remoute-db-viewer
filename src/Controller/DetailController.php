<?php


namespace App\Controller;

use App\Service\DetailRowTableService;
use App\Service\DynamicTableInfoService;
use App\Service\TableView\ViewColumnsRowDetailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailController extends AbstractController
{
    /**
     * @var DynamicTableInfoService
     */
    private $dynamicTableInfoService;
    /**
     * @var DetailRowTableService
     */
    private $detailRowTableService;
    /**
     * @var ViewColumnsRowDetailService
     */
    private $viewColumnsRowDetailService;

    public function __construct(
        DynamicTableInfoService $dynamicTableInfoService,
        DetailRowTableService $detailRowTableService,
        ViewColumnsRowDetailService $viewColumnsRowDetailService
    ) {
        $this->dynamicTableInfoService = $dynamicTableInfoService;
        $this->detailRowTableService = $detailRowTableService;
        $this->viewColumnsRowDetailService = $viewColumnsRowDetailService;
    }

    /**
     * @Route("/detail/{db}/{tableName}/{id}")
     * @param $db
     * @param $tableName
     * @param $id
     * @return Response
     */
    public function list($db, $tableName, $id)
    {
        $table = $this->dynamicTableInfoService->getTableInfo($db, $tableName);
        $row = $this->detailRowTableService->getRow($table, $id);
        $columns = $this->viewColumnsRowDetailService->getColumns($table);

        return $this->render('table/detail.html.twig', [
            'row' => $row,
            'columns' => $columns
        ]);
    }
}