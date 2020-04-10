<?php


namespace App\Controller;

use App\Service\DetailRowTableService;
use App\Service\DynamicTableInfoService;
use App\Service\TableView\ViewColumnsRowDetailService;
use App\Service\TableView\ViewColumnsRowPopupService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PopupController extends AbstractController
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
     * @var ViewColumnsRowPopupService
     */
    private $viewColumnsRowPopupService;

    public function __construct(
        DynamicTableInfoService $dynamicTableInfoService,
        DetailRowTableService $detailRowTableService,
        ViewColumnsRowPopupService $viewColumnsRowPopupService
    ) {
        $this->dynamicTableInfoService = $dynamicTableInfoService;
        $this->detailRowTableService = $detailRowTableService;
        $this->viewColumnsRowPopupService = $viewColumnsRowPopupService;
    }

    /**
     * @Route("/popup/{db}/{tableName}/{id}")
     * @param $db
     * @param $tableName
     * @param $id
     * @return Response
     */
    public function list($db, $tableName, $id)
    {
        $table = $this->dynamicTableInfoService->getTableInfo($db, $tableName);
        $row = $this->detailRowTableService->getRow($table, $id);
        $columns = $this->viewColumnsRowPopupService->getColumns($table);

        return $this->render('table/popup.html.twig', [
            'row' => $row,
            'columns' => $columns
        ]);
    }
}