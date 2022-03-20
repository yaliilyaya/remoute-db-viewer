<?php

namespace App\Controller\Editor;

use App\Entity\DataBaseInfo;
use App\Factory\ConnectionBuilder;
use App\Form\Type\RemoteTableType;
use App\Repository\DataBaseInfoRepository;
use App\Repository\TableInfoRepository;
use App\Service\SyncRemoteTableService;
use Doctrine\DBAL\DBALException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TableInfoController  extends AbstractController
{
    /**
     * @var TableInfoRepository
     */
    private $tableRepository;
    /**
     * @var SyncRemoteTableService
     */
    private $syncRemoteTableService;
    /**
     * @var ConnectionBuilder
     */
    private $connectionByDataBaseFactory;
    /**
     * @var TableInfoRepository
     */
    private $remoteTableRepository;

    /**
     * EditorTableDataBaseController constructor.
     * @param TableInfoRepository $tableRepository
     * @param TableInfoRepository $remoteTableRepository
     * @param ConnectionBuilder $connectionByDataBaseFactory
     * @param SyncRemoteTableService $syncRemoteTableService
     */
    public function __construct(
        TableInfoRepository    $tableRepository,
        TableInfoRepository    $remoteTableRepository,
        ConnectionBuilder      $connectionByDataBaseFactory,
        SyncRemoteTableService $syncRemoteTableService
    ) {
        $this->tableRepository = $tableRepository;
        $this->syncRemoteTableService = $syncRemoteTableService;
        $this->connectionByDataBaseFactory = $connectionByDataBaseFactory;
        $this->remoteTableRepository = $remoteTableRepository;
    }

    /**
     * @Route("/table/list", name="tableList")
     * @return Response
     */
    public function list()
    {
        /** @var DataBaseInfo[] $dataBase */
        $tables = $this->tableRepository->findAll();

        return $this->render('editorDataBase/tables.html.twig', [
            'tables' => $tables
        ]);
    }

    /**
     * @Route("/table/sync/{tableId}", name="syncTable")
     * @param $tableId
     * @return Response
     * @throws DBALException
     */
    public function syncTable($tableId)
    {
        $table = $this->tableRepository->find($tableId);
        $connection = $this->connectionByDataBaseFactory->createConnection($table->getDatabase());

        $this->syncRemoteTableService->sync($connection, $table);

        return $this->redirect("/table/list");
    }

    /**
     * @Route("/config/table/{tableId}", name="configTable")
     * @param Request $request
     * @param $tableId
     * @return Response
     */
    public function configTable(Request $request, $tableId)
    {
        $table = $this->remoteTableRepository->find($tableId);

        $form = $this->createForm(RemoteTableType::class, $table, ['method' => RemoteTableType::METHOD_EDIT_TYPE]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $dataBase = $form->getData();
            $this->remoteTableRepository->save($dataBase);

            //return $this->redirect("/dataBase/list");
        }

        return $this->render('config/table.html.twig', [
            'form' => $form->createView(),
            'table' => $table,
            'edit' => true
        ]);
    }

    /**
     * @Route("/config/columns/{tableId}", name="configColumns")
     * @param $tableId
     * @return Response
     * @throws DBALException
     */
    public function configColumns($tableId)
    {
        $table = $this->remoteTableRepository->find($tableId);

        $connection = $this->connectionByDataBaseFactory->createConnection($table->getDatabase());
        $table->setConnection($connection);

        return $this->render('config/columns.html.twig', [
            'columns' => $table->getColumns()
        ]);
    }

}