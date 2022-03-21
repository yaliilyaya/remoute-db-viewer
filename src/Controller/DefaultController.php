<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package App\Controller
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    public function index()
    {
        return $this->render('mainPage.html.twig', []);
    }

    /**
     * @Route("/icons")
     * @return Response
     */
    public function icons()
    {
        return $this->render('main/icons.html.twig', []);
    }
}