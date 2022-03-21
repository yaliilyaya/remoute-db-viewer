<?php


namespace App\Controller;

use App\Service\DetailRowTableService;
use App\Service\TableView\ViewColumnsRowPopupService;
use Doctrine\DBAL\DBALException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @uses Route
 */
class PopupController extends AbstractController
{
    /**
     * @deprecated
     * @var \App\Service\RemoteTableInfoService
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
     * @deprecated
     * @var \App\Factory\ConnectionFactory
     */
    private $connectionFactory;

    public function __construct(
        DetailRowTableService $detailRowTableService,
        ViewColumnsRowPopupService $viewColumnsRowPopupService
    ) {
        $this->detailRowTableService = $detailRowTableService;
        $this->viewColumnsRowPopupService = $viewColumnsRowPopupService;
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