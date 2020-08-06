<?php


namespace App\Controller;

use App\Repository\RemoteTableRepository;
use App\Service\DetailRowTableService;
use App\Service\TableView\ViewColumnsRowDetailService;
use Doctrine\DBAL\DBALException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailController extends AbstractController
{
    /**
     * @var DetailRowTableService
     */
    private $detailRowTableService;
    /**
     * @var ViewColumnsRowDetailService
     */
    private $viewColumnsRowDetailService;
    /**
     * @var RemoteTableRepository
     */
    private $remoteTableRepository;

    public function __construct(
        DetailRowTableService $detailRowTableService,
        ViewColumnsRowDetailService $viewColumnsRowDetailService,
        RemoteTableRepository $remoteTableRepository
    ) {
        $this->detailRowTableService = $detailRowTableService;
        $this->viewColumnsRowDetailService = $viewColumnsRowDetailService;
        $this->remoteTableRepository = $remoteTableRepository;
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
        $table = $this->remoteTableRepository->findByTableFullName($db, $tableName);

        if (!$table)
        {
            throw $this->createNotFoundException('The table does not exist');
        }

        $row = $this->detailRowTableService->getRow($table, $id);
        $columns = $this->viewColumnsRowDetailService->getColumns($table);

        if (!$row)
        {
            throw $this->createNotFoundException('The row does not exist');
        }

        return $this->render('table/detail.html.twig', [
            'row' => $row,
            'columns' => $columns
        ]);
    }
}