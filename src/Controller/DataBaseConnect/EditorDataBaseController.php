<?php


namespace App\Controller\DataBaseConnect;


use App\Entity\DataBase;
use App\Form\Type\DataBaseType;
use App\Repository\DataBaseRepository;
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
    private $baseRepository;

    public function __construct(DataBaseRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
    }

    /**
     * @Route("/dataBase/delete/{id}")
     * @param $id
     * @return Response
     */
    public function delete($id)
    {
        /** @var DataBase $dataBase */
        $dataBase = $this->baseRepository->find($id);
        if ($dataBase)
        {
            $this->baseRepository->remove($dataBase);
        }

        return new Response(
            '<html><body>remove: '.$id . '</body></html>'
        );
    }

    /**
     * @Route("/dataBase/connect")
     * @param Request $request
     * @return Response
     */
    public function connect(Request $request)
    {
        $dataBase = new DataBase();

        $form = $this->createForm(DataBaseType::class, $dataBase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $dataBase = $form->getData();
            $this->baseRepository->save($dataBase);
        }

        return $this->render('editorDataBase/connect.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}