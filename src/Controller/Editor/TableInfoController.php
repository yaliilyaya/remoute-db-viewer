<?php

namespace App\Controller\Editor;

use App\Entity\DataBaseInfo;
use App\Form\Type\RemoteTableType;
use App\Repository\TableInfoRepository;
use Doctrine\DBAL\DBALException;
use RemoteDataBase\Builder\TableRemoteRepositoryBuilder;
use RemoteDataBase\Exception\ConnectionException;
use RemoteDataBase\Factory\ConnectionBuilder;
use RemoteDataBase\Service\SyncRemoteTableService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @uses Route
 */
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
     * @var TableInfoRepository
     */
    private $remoteTableRepository;

    /**
     * EditorTableDataBaseController constructor.
     * @param TableInfoRepository $tableRepository
     * @param TableInfoRepository $remoteTableRepository
     * @param SyncRemoteTableService $syncRemoteTableService
     */
    public function __construct(
        TableInfoRepository    $tableRepository,
        TableInfoRepository    $remoteTableRepository,
        SyncRemoteTableService $syncRemoteTableService
    ) {
        $this->tableRepository = $tableRepository;
        $this->syncRemoteTableService = $syncRemoteTableService;
        $this->remoteTableRepository = $remoteTableRepository;
    }

    /**
     * @Route("/settings/table/list", name="settings.table.list")
     * @return Response
     */
    public function list(): Response
    {
        /** @var DataBaseInfo[] $dataBase */
        $tables = $this->tableRepository->findAll();

        return $this->render('editorDataBase/tables.html.twig', [
            'tables' => $tables
        ]);
    }

    /**
     * @Route("/settings/table/sync/{tableId}", name="settings.table.sync")
     * @param $tableId
     * @return Response
     * @throws ConnectionException
     */
    public function syncTable($tableId): Response
    {
        $table = $this->tableRepository->find($tableId);
        $this->syncRemoteTableService->sync($table);

        return $this->redirectToRoute("settings.table.list");
    }

    /**
     * @Route("/settings/table/edit/{tableId}", name="settings.table.edit")
     * @param Request $request
     * @param $tableId
     * @return Response
     */
    public function editTable(
        Request $request,
        $tableId
    ): Response {
        $table = $this->remoteTableRepository->find($tableId);

        $form = $this->createForm(RemoteTableType::class, $table, ['method' => RemoteTableType::METHOD_EDIT_TYPE]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dataBase = $form->getData();
            $this->remoteTableRepository->save($dataBase);

            return $this->redirectToRoute("settings.table.list");
        }

        return $this->render('config/table.html.twig', [
            'form' => $form->createView(),
            'table' => $table,
            'edit' => true
        ]);
    }

    /**
     * @Route("/settings/columns/config/{tableId}", name="settings.columns.config")
     * @param $tableId
     * @return Response
     */
    public function configColumns(
        $tableId
    ): Response {
        $tableInfo = $this->remoteTableRepository->find($tableId);

        return $this->render('config/columns.html.twig', [
            'columns' => $tableInfo->getColumns()
        ]);
    }
}