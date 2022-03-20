<?php


namespace App\Controller\Editor;

use App\Form\Type\RemoteTableColumnType;
use App\Form\Type\RemoteTableType;
use App\Repository\ColumnInfoRepository;
use App\Repository\TableInfoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RemoteColumnController  extends AbstractController
{
    /**
     * @var TableInfoRepository
     */
    private $remoteTableRepository;
    /**
     * @var ColumnInfoRepository
     */
    private $remoteTableColumnRepository;

    public function __construct(
        TableInfoRepository         $remoteTableRepository,
        ColumnInfoRepository $remoteTableColumnRepository
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

    /**
     * @Route("/config/column/enabledViewList/{columnId}/{enabled}", name="columnEnabledViewList")
     * @param int $columnId
     * @param string $enabled
     * @return RedirectResponse
     */
    public function enabledViewList($columnId, $enabled)
    {
        $column = $this->remoteTableColumnRepository->find($columnId);
        $column->setIsViewList($enabled === 'true');

        $this->remoteTableColumnRepository->save($column);

        return $this->redirect('/config/columns/' . $column->getTable()->getId());
    }

    /**
     * @Route("/config/column/enabledViewDetail/{columnId}/{enabled}", name="columnEnabledViewDetail")
     * @param int $columnId
     * @param string $enabled
     * @return RedirectResponse
     */
    public function enabledViewDetail(int $columnId, string $enabled)
    {
        $column = $this->remoteTableColumnRepository->find($columnId);
        $column->setIsViewDetail($enabled === 'true');

        $this->remoteTableColumnRepository->save($column);

        return $this->redirect('/config/columns/' . $column->getTable()->getId());
    }

    /**
     * @Route("/config/column/enabledViewPopup/{columnId}/{enabled}", name="columnEnabledViewPopup")
     * @param int $columnId
     * @param string $enabled
     * @return RedirectResponse
     */
    public function enabledViewPopup($columnId, $enabled)
    {
        $column = $this->remoteTableColumnRepository->find($columnId);
        $column->setIsViewPopup($enabled === 'true');

        $this->remoteTableColumnRepository->save($column);

        return $this->redirect('/config/columns/' . $column->getTable()->getId());
    }

}