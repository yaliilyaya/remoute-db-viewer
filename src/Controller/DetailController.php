<?php


namespace App\Controller;

use App\Factory\ConnectionFactory;
use App\Service\DetailRowTableService;
use App\Service\RemoteTableInfoService;
use App\Service\TableView\ViewColumnsRowDetailService;
use Doctrine\DBAL\DBALException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailController extends AbstractController
{
    /**
     * @var RemoteTableInfoService
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
    /**
     * @var ConnectionFactory
     */
    private $connectionFactory;

    public function __construct(
        RemoteTableInfoService $dynamicTableInfoService,
        DetailRowTableService $detailRowTableService,
        ViewColumnsRowDetailService $viewColumnsRowDetailService,
        ConnectionFactory $connectionFactory
    ) {
        $this->dynamicTableInfoService = $dynamicTableInfoService;
        $this->detailRowTableService = $detailRowTableService;
        $this->viewColumnsRowDetailService = $viewColumnsRowDetailService;
        $this->connectionFactory = $connectionFactory;
    }

    /**
     * @Route("/detail/{db}/{tableName}/{id}", name="detail")
     * @param $db
     * @param $tableName
     * @param $id
     * @return Response
     * @throws DBALException
     */
    public function list($db, $tableName, $id)
    {
        $connection = $this->connectionFactory->createConnection($db);
        $table = $this->dynamicTableInfoService->getTableInfo($connection, $tableName);

        dump($table);
        $row = $this->detailRowTableService->getRow($table, $id);
        $columns = $this->viewColumnsRowDetailService->getColumns($table);

        dump($row);

        return $this->render('table/detail.html.twig', [
            'row' => $row,
            'columns' => $columns
        ]);
    }
}