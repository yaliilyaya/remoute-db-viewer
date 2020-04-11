<?php


namespace App\Controller\DataBaseConnect;


use App\Entity\RemoteDataBase;
use App\Form\Type\DataBaseType;
use App\Repository\DataBaseRepository;
use App\Service\SyncRemoteTableService;
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
     * @var SyncRemoteTableService
     */
    private $syncRemoteTableService;

    public function __construct(
        DataBaseRepository $baseRepository,
        SyncRemoteTableService $syncRemoteTableService
    ) {
        $this->dataBaseRepository = $baseRepository;
        $this->syncRemoteTableService = $syncRemoteTableService;
    }

    /**
     * @Route("/dataBase/delete/{id}")
     * @param $id
     * @return Response
     */
    public function delete($id)
    {
        /** @var RemoteDataBase $dataBase */
        $dataBase = $this->dataBaseRepository->find($id);
        if ($dataBase)
        {
            $this->dataBaseRepository->remove($dataBase);
        }

        return $this->redirect("/dataBase/list");
    }

    /**
     * @Route("/dataBase/activate/{id}")
     * @param $id
     * @return Response
     */
    public function activate($id)
    {
        /** @var RemoteDataBase $dataBase */
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
     * @Route("/dataBase/connect")
     * @param Request $request
     * @return Response
     */
    public function connect(Request $request)
    {
        $dataBase = new RemoteDataBase();
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
     * @Route("/dataBase/edit/{id}")
     * @param Request $request
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        /** @var RemoteDataBase $dataBase */
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
     * @Route("/dataBase/list")
     * @return Response
     */
    public function list()
    {
        /** @var RemoteDataBase[] $dataBase */
        $dataBases = $this->dataBaseRepository->findAll();

        return $this->render('editorDataBase/list.html.twig', [
            'dataBases' => $dataBases
        ]);
    }

    /**
     * @Route("/table/sync/{dbName}", name="syncTable")
     * @param $dbName
     * @return Response
     */
    public function syncTable($dbName)
    {
        $dataBases = $this->dataBaseRepository->findByAlias($dbName);
        $this->syncRemoteTableService->sync($dataBases);

        return $this->redirect("/dataBase/list");
    }
}