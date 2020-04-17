<?php


namespace App\Controller\DataBaseConnect;


use App\Entity\RemoteDataBase;
use App\Factory\ConnectionByDataBaseFactory;
use App\Repository\DataBaseRepository;
use App\Repository\RemoteTableRepository;
use App\Service\SyncRemoteTableService;
use Doctrine\DBAL\DBALException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditorTableDataBaseController  extends AbstractController
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
     * EditorTableDataBaseController constructor.
     * @param RemoteTableRepository $tableRepository
     * @param DataBaseRepository $dataBaseRepository
     * @param ConnectionByDataBaseFactory $connectionByDataBaseFactory
     * @param SyncRemoteTableService $syncRemoteTableService
     */
    public function __construct(
        RemoteTableRepository $tableRepository,
        DataBaseRepository $dataBaseRepository,
        ConnectionByDataBaseFactory $connectionByDataBaseFactory,
        SyncRemoteTableService $syncRemoteTableService
    ) {
        $this->tableRepository = $tableRepository;
        $this->dataBaseRepository = $dataBaseRepository;
        $this->syncRemoteTableService = $syncRemoteTableService;
        $this->connectionByDataBaseFactory = $connectionByDataBaseFactory;
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
}