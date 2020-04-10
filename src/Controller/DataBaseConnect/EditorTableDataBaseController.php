<?php


namespace App\Controller\DataBaseConnect;


use App\Entity\DataBase;
use App\Repository\DataBaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditorTableDataBaseController  extends AbstractController
{
    /**
     * @var DataBaseRepository
     */
    private $baseRepository;

    public function __construct(DataBaseRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
    }


}