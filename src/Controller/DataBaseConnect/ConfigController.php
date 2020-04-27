<?php


namespace App\Controller\DataBaseConnect;


use App\Entity\RemoteDataBase;
use App\Factory\ConnectionByDataBaseFactory;
use App\Repository\DataBaseRepository;
use App\Repository\RemoteTableRepository;
use App\Service\SyncRemoteTableService;
use Doctrine\DBAL\DBALException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConfigController  extends AbstractController
{
    /**
     * @var RemoteTableRepository
     */
    private $remoteTableRepository;
    /**
     * @var ConnectionByDataBaseFactory
     */
    private $connectionByDataBaseFactory;

    public function __construct(
        RemoteTableRepository $remoteTableRepository,
        ConnectionByDataBaseFactory $connectionByDataBaseFactory
    ) {

        $this->remoteTableRepository = $remoteTableRepository;
        $this->connectionByDataBaseFactory = $connectionByDataBaseFactory;
    }

    /**
     * @Route("/config/column/{tableId}", name="configColumn")
     * @param $tableId
     * @return Response
     * @throws DBALException
     */
    public function configColumn($tableId)
    {

        $table = $this->remoteTableRepository->find($tableId);

        $connection = $this->connectionByDataBaseFactory->createConnection($table->getDatabase());
        $table->setConnection($connection);

        return $this->render('config/column.html.twig', [
            'columns' => $table->getColumns()
        ]);
    }
}