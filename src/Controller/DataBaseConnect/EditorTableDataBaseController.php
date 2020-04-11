<?php


namespace App\Controller\DataBaseConnect;


use App\Entity\DataBase;
use App\Repository\DataBaseRepository;
use App\Repository\RemoteTableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditorTableDataBaseController  extends AbstractController
{

    /**
     * @var RemoteTableRepository
     */
    private $tableRepository;

    public function __construct(RemoteTableRepository $tableRepository)
    {
        $this->tableRepository = $tableRepository;
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

}