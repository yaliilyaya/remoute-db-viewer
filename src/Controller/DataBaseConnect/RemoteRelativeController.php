<?php


namespace App\Controller\DataBaseConnect;

use App\Entity\RemoteRelative;
use App\Form\Type\RemoteRelativeType;
use App\Repository\RemoteRelativeRepository;
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
     * RemoteRelativeController constructor.
     * @param RemoteRelativeRepository $remoteRelativeRepository
     */
    public function __construct(
        RemoteRelativeRepository $remoteRelativeRepository
    ) {
        $this->remoteRelativeRepository = $remoteRelativeRepository;
    }

    /**
     * @Route("/relative/create")
     * @param Request $request
     * @return Response
     */
    public function connect(Request $request)
    {
        $remoteRelative = new RemoteRelative();

        $form = $this->createForm(RemoteRelativeType::class, $remoteRelative);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $remoteRelative = $form->getData();
            $this->remoteRelativeRepository->save($remoteRelative);

            die(__FILE__);
//            return $this->redirect("/relative/list");
        }

        return $this->render('editorDataBase/relative.create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}