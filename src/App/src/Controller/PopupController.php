<?php


namespace App\Controller;

use App\Factory\ConnectionFactory;
use App\Service\DetailRowTableService;
use App\Service\RemoteTableInfoService;
use App\Service\TableView\ViewColumnsRowPopupService;
use Doctrine\DBAL\DBALException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PopupController extends AbstractController
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
     * @var ViewColumnsRowPopupService
     */
    private $viewColumnsRowPopupService;
    /**
     * @var ConnectionFactory
     */
    private $connectionFactory;

    public function __construct(
        RemoteTableInfoService $dynamicTableInfoService,
        DetailRowTableService $detailRowTableService,
        ViewColumnsRowPopupService $viewColumnsRowPopupService,
        ConnectionFactory $connectionFactory
    ) {
        $this->dynamicTableInfoService = $dynamicTableInfoService;
        $this->detailRowTableService = $detailRowTableService;
        $this->viewColumnsRowPopupService = $viewColumnsRowPopupService;
        $this->connectionFactory = $connectionFactory;
    }

    /**
     * @Route("/popup/{db}/{tableName}/{id}")
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
        $row = $this->detailRowTableService->getRow($table, $id);
        $columns = $this->viewColumnsRowPopupService->getColumns($table);

        return $this->render('table/popup.html.twig', [
            'row' => $row,
            'columns' => $columns
        ]);
    }
}