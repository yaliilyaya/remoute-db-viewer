<?php


namespace App\Controller\Editor;


use App\Entity\DataBaseInfo;
use App\Form\Type\DataBaseType;
use App\Repository\DataBaseRepository;
use App\Service\SyncRemoteDataBaseTableService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class EditorDataBaseController
 * @package App\Controller\DataBaseConnect
 */
class EditorDataBaseController extends AbstractController
{
    /**
     * @var DataBaseRepository
     */
    private $dataBaseRepository;
    /**
     * @var SyncRemoteDataBaseTableService
     */
    private $syncRemoteDataBaseTableService;

    public function __construct(
        DataBaseRepository $baseRepository,
        SyncRemoteDataBaseTableService $syncRemoteDataBaseTableService
    ) {
        $this->dataBaseRepository = $baseRepository;
        $this->syncRemoteDataBaseTableService = $syncRemoteDataBaseTableService;
    }

    /**
     * @Route("/dataBase/delete/{id}", name="remoteDatabaseDelete")
     * @param $id
     * @return Response
     */
    public function delete($id)
    {
        /** @var DataBaseInfo $dataBase */
        $dataBase = $this->dataBaseRepository->find($id);
        if ($dataBase)
        {
            $this->dataBaseRepository->remove($dataBase);
        }

        return $this->redirect("/dataBase/list");
    }

    /**
     * @Route("/dataBase/activate/{id}", name="remoteDatabaseActivate")
     * @param $id
     * @return Response
     */
    public function activate($id)
    {
        /** @var DataBaseInfo $dataBase */
        $dataBase = $this->dataBaseRepository->find($id);
        if ($dataBase)
        {
            $isActive = !$dataBase->isActive();
            $dataBase->setIsActive($isActive);
            $this->dataBaseRepository->save($dataBase);
        }

        return $this->redirect("/dataBase/list");
    }

    /**
     * @Route("/dataBase/connect", name="remoteDatabaseConnect")
     * @param Request $request
     * @return Response
     */
    public function connect(Request $request)
    {
        $dataBase = new DataBaseInfo();
        $dataBase->setPort(3306);

        $form = $this->createForm(DataBaseType::class, $dataBase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $dataBase = $form->getData();
            $this->dataBaseRepository->save($dataBase);

            return $this->redirect("/dataBase/list");
        }

        return $this->render('editorDataBase/connect.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/dataBase/edit/{id}", name="remoteDatabaseEdit")
     * @param Request $request
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        /** @var DataBaseInfo $dataBase */
        $dataBase = $this->dataBaseRepository->find($id);

        $form = $this->createForm(DataBaseType::class, $dataBase, ['method' => DataBaseType::METHOD_EDIT_TYPE]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $dataBase = $form->getData();
            $this->dataBaseRepository->save($dataBase);

            return $this->redirect("/dataBase/list");
        }

        return $this->render('editorDataBase/connect.html.twig', [
            'form' => $form->createView(),
            'edit' => true
        ]);
    }

    /**
     * @Route("/dataBase/list", name="dataBaseList")
     * @return Response
     */
    public function list()
    {
        /** @var DataBaseInfo[] $dataBase */
        $dataBases = $this->dataBaseRepository->findAll();

        return $this->render('editorDataBase/list.html.twig', [
            'dataBases' => $dataBases
        ]);
    }

    /**
     * @Route("/dataBase/table/sync/{dbName}", name="syncTables")
     * @param $dbName
     * @return Response
     */
    public function syncTable($dbName)
    {
        $dataBases = $this->dataBaseRepository->findByAlias($dbName);
        $this->syncRemoteDataBaseTableService->sync($dataBases);

        return $this->redirect("/dataBase/list");
    }
}