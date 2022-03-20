<?php


namespace App\Controller\Editor;


use App\Entity\DataBaseInfo;
use App\Form\Type\DataBaseType;
use App\Repository\DataBaseInfoRepository;
use App\Service\SyncDataBaseTableService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class EditorDataBaseController
 * @package App\Controller\DataBaseConnect
 */
class DataBaseInfoController extends AbstractController
{
    /**
     * @var DataBaseInfoRepository
     */
    private $dataBaseRepository;

    public function __construct(
        DataBaseInfoRepository         $baseRepository
    ) {
        $this->dataBaseRepository = $baseRepository;
    }

    /**
     * @Route("/settings/dataBase/delete/{id}", name="settings.dataBase.delete")
     * @param $id
     * @return Response
     */
    public function delete($id): Response
    {
        /** @var DataBaseInfo $dataBase */
        $dataBase = $this->dataBaseRepository->find($id);
        if ($dataBase)
        {
            $this->dataBaseRepository->remove($dataBase);
        }

        return $this->redirectToRoute("settings.dataBase.list");
    }

    /**
     * @Route("/settings/dataBase/activate/{id}", name="settings.dataBase.activate")
     * @param $id
     * @return Response
     */
    public function activate($id): Response
    {
        /** @var DataBaseInfo $dataBase */
        $dataBase = $this->dataBaseRepository->find($id);
        if ($dataBase)
        {
            $isActive = !$dataBase->isActive();
            $dataBase->setIsActive($isActive);
            $this->dataBaseRepository->save($dataBase);
        }

        return $this->redirectToRoute("settings.dataBase.list");
    }

    /**
     * @Route("/settings/dataBase/connect", name="settings.dataBase.connect")
     * @param Request $request
     * @return Response
     */
    public function connect(Request $request): Response
    {
        $dataBase = new DataBaseInfo();
        $dataBase->setPort(3306);

        $form = $this->createForm(DataBaseType::class, $dataBase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $dataBase = $form->getData();
            $this->dataBaseRepository->save($dataBase);

            return $this->redirectToRoute("settings.dataBase.list");
        }

        return $this->render('editorDataBase/connect.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/settings/dataBase/edit/{id}", name="settings.dataBase.edit")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function edit(Request $request, $id): Response
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
     * @Route("/settings/dataBase/list", name="settings.dataBase.list")
     * @return Response
     */
    public function list(): Response
    {
        /** @var DataBaseInfo[] $dataBase */
        $dataBases = $this->dataBaseRepository->findAll();

        return $this->render('editorDataBase/list.html.twig', [
            'dataBases' => $dataBases
        ]);
    }

    /**
     * @Route("/settings/dataBase/table/sync/{dbName}", name="settings.dataBase.syncTables")
     * @param SyncDataBaseTableService $syncDataBaseTableService
     * @param $id
     * @return Response
     */
    public function syncTable(
        SyncDataBaseTableService $syncDataBaseTableService,
        $id
    ): Response {
        $dataBase = $this->dataBaseRepository->find($id);
        $syncDataBaseTableService->sync($dataBase);

        return $this->redirect("/dataBase/list");
    }
}