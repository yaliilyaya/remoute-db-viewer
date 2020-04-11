<?php


namespace App\Controller\DataBaseConnect;


use App\Entity\DataBase;
use App\Repository\DataBaseRepository;
use App\Repository\RemoteTableRepository;
use App\Service\SyncRemoteTableService;
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
     * EditorTableDataBaseController constructor.
     * @param RemoteTableRepository $tableRepository
     * @param DataBaseRepository $dataBaseRepository
     * @param SyncRemoteTableService $syncRemoteTableService
     */
    public function __construct(
        RemoteTableRepository $tableRepository,
        DataBaseRepository $dataBaseRepository,
        SyncRemoteTableService $syncRemoteTableService
    ) {
        $this->tableRepository = $tableRepository;
        $this->dataBaseRepository = $dataBaseRepository;
        $this->syncRemoteTableService = $syncRemoteTableService;
    }

    /**
     * @Route("/table/list")
     * @return Response
     */
    public function list()
    {
        /** @var DataBase[] $dataBase */
        $tables = $this->tableRepository->findAll();

        return $this->render('editorDataBase/tables.html.twig', [
            'tables' => $tables
        ]);
    }
    /**
     * @Route("/table/sync")
     * @return Response
     */
    public function sync()
    {
        /** @var DataBase[] $dataBase */
        $dataBases = $this->dataBaseRepository->findAll();
        $this->syncRemoteTableService->sync($dataBases);

        die(__FILE__);

        return $this->redirect("/table/list");
    }

}