<?php


namespace App\Controller\Editor;

use App\Entity\RelativeInfo;
use App\Form\Type\RemoteRelativeType;
use App\Repository\RemoteRelativeRepository;
use App\Repository\RemoteTableColumnRepository;
use App\Repository\RemoteTableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RemoteRelativeController
 * @package App\Controller\DataBaseConnect
 */
class RemoteRelativeController extends AbstractController
{
    /**
     * @var RemoteRelativeRepository
     */
    private $remoteRelativeRepository;
    /**
     * @var RemoteTableColumnRepository
     */
    private $remoteTableColumnRepository;
    /**
     * @var RemoteTableRepository
     */
    private $remoteTableRepository;

    /**
     * RemoteRelativeController constructor.
     * @param RemoteRelativeRepository $remoteRelativeRepository
     * @param RemoteTableColumnRepository $remoteTableColumnRepository
     * @param RemoteTableRepository $remoteTableRepository
     */
    public function __construct(
        RemoteRelativeRepository $remoteRelativeRepository,
        RemoteTableColumnRepository $remoteTableColumnRepository,
        RemoteTableRepository $remoteTableRepository
    ) {
        $this->remoteRelativeRepository = $remoteRelativeRepository;
        $this->remoteTableColumnRepository = $remoteTableColumnRepository;
        $this->remoteTableRepository = $remoteTableRepository;
    }

    /**
     * @Route("/relative/create/{columnId}", name="relativeCreate")
     * @param Request $request
     * @param $columnId
     * @return Response
     */
    public function create(Request $request, $columnId)
    {
        $column = $this->remoteTableColumnRepository->find($columnId);

        $remoteRelative = new RelativeInfo();
        $remoteRelative->setColumnFrom($column);

        $form = $this->createForm(RemoteRelativeType::class, $remoteRelative);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var RelativeInfo $remoteRelative */
            $remoteRelative = $form->getData();
            $this->remoteRelativeRepository->save($remoteRelative);

            return $this->redirect('/relative/list/'. $remoteRelative->getColumnFrom()->getTable()->getId());
        }

        return $this->render('editorDataBase/relative.create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/relative/remove/{relativeId}", name="relativeRemove")
     * @param $relativeId
     * @return Response
     */
    public function remove($relativeId)
    {
        $remoteRelative = $this->remoteRelativeRepository->find($relativeId);
        $this->remoteRelativeRepository->remove($remoteRelative);

        return $this->redirect('/relative/list/'. $remoteRelative->getColumnFrom()->getTable()->getId());
    }

    /**
     * @Route("/relative/list", name="relativeList")
     * @return Response
     */
    public function list()
    {
        $relatives = $this->remoteRelativeRepository->findAll();

        return $this->render('editorDataBase/relative.list.html.twig', [
            'table' => null,
            'relatives' => $relatives,
        ]);
    }

    /**
     * @Route("/relative/table/{tableId}", name="tableRelative")
     * @param $tableId
     * @return Response
     */
    public function tableList($tableId)
    {
        $table =  $this->remoteTableRepository->find($tableId);
        $relatives = $this->remoteRelativeRepository->findByTableId($tableId);

        return $this->render('editorDataBase/relative.list.html.twig', [
            'table' => $table,
            'relatives' => $relatives,
        ]);
    }
}