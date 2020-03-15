<?php

namespace App\Controller;

use App\Service\DataListTableService;
use App\Service\DynamicTableInfoService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListController
{
    /**
     * @var DynamicTableInfoService
     */
    private $dynamicTableInfoService;
    /**
     * @var DataListTableService
     */
    private $dataListTableService;

    public function __construct(
        DynamicTableInfoService $dynamicTableInfoService,
        DataListTableService $dataListTableService
    ) {
        $this->dynamicTableInfoService = $dynamicTableInfoService;
        $this->dataListTableService = $dataListTableService;
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

        dump($rows);

        return new Response(
            '<html><body>Lucky number: '.$db .' '.$tableName.'</body></html>'
        );
    }
}