<?php


namespace App\Controller\Editor;


use App\Entity\RemoteDataBase;
use App\Factory\ConnectionByDataBaseFactory;
use App\Form\Type\RemoteTableType;
use App\Repository\DataBaseRepository;
use App\Repository\RemoteTableRepository;
use App\Service\SyncRemoteTableService;
use Doctrine\DBAL\DBALException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RemoteTableController  extends AbstractController
{

    /**
     * @var RemoteTableRepository
     */
    private $tableRepository;
    /**
     * @var DataBaseRepository
     */
    private $dataBaseRepository;
    /**
     * @var SyncRemoteTableService
     */
    private $syncRemoteTableService;
    /**
     * @var ConnectionByDataBaseFactory
     */
    private $connectionByDataBaseFactory;
    /**
     * @var RemoteTableRepository
     */
    private $remoteTableRepository;

    /**
     * EditorTableDataBaseController constructor.
     * @param RemoteTableRepository $tableRepository
     * @param RemoteTableRepository $remoteTableRepository
     * @param DataBaseRepository $dataBaseRepository
     * @param ConnectionByDataBaseFactory $connectionByDataBaseFactory
     * @param SyncRemoteTableService $syncRemoteTableService
     */
    public function __construct(
        RemoteTableRepository $tableRepository,
        RemoteTableRepository $remoteTableRepository,
        DataBaseRepository $dataBaseRepository,
        ConnectionByDataBaseFactory $connectionByDataBaseFactory,
        SyncRemoteTableService $syncRemoteTableService
    ) {
        $this->tableRepository = $tableRepository;
        $this->dataBaseRepository = $dataBaseRepository;
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
        /** @var RemoteDataBase[] $dataBase */
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