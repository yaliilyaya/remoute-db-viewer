<?php


namespace App\Controller;


use App\Service\DataListTableService;
use App\Service\DetailRowTableService;
use App\Service\DynamicTableInfoService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailController
{
    /**
     * @var DynamicTableInfoService
     */
    private $dynamicTableInfoService;
    /**
     * @var DetailRowTableService
     */
    private $detailRowTableService;

    public function __construct(
        DynamicTableInfoService $dynamicTableInfoService,
        DetailRowTableService $detailRowTableService
    ) {
        $this->dynamicTableInfoService = $dynamicTableInfoService;
        $this->detailRowTableService = $detailRowTableService;
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

        dump($row);

        return new Response(
            '<html><body>Lucky number: '.$db .' '.$tableName.'</body></html>'
        );
    }
}