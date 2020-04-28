<?php


namespace App\Controller\Editor;

use App\Form\Type\RemoteTableColumnType;
use App\Form\Type\RemoteTableType;
use App\Repository\RemoteTableColumnRepository;
use App\Repository\RemoteTableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RemoteColumnController  extends AbstractController
{
    /**
     * @var RemoteTableRepository
     */
    private $remoteTableRepository;
    /**
     * @var RemoteTableColumnRepository
     */
    private $remoteTableColumnRepository;

    public function __construct(
        RemoteTableRepository $remoteTableRepository,
        RemoteTableColumnRepository $remoteTableColumnRepository
    ) {

        $this->remoteTableRepository = $remoteTableRepository;
        $this->remoteTableColumnRepository = $remoteTableColumnRepository;
    }




    /**
     * @Route("/config/column/{columnId}", name="configColumn")
     * @param Request $request
     * @param $columnId
     * @return Response
     */
    public function configColumn(Request $request, $columnId)
    {
        $column = $this->remoteTableColumnRepository->find($columnId);

        $form = $this->createForm(RemoteTableColumnType::class, $column, ['method' => RemoteTableType::METHOD_EDIT_TYPE]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $column = $form->getData();
            $this->remoteTableRepository->save($column);

            //return $this->redirect("/dataBase/list");
        }


        return $this->render('config/column.html.twig', [
            'form' => $form->createView(),
            'column' => $column,
            'edit' => true
        ]);
    }

}