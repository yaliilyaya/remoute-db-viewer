<?php


namespace App\Controller\DataBaseConnect;

use App\Factory\ConnectionByDataBaseFactory;
use App\Form\Type\RemoteTableType;
use App\Repository\RemoteTableColumnRepository;
use App\Repository\RemoteTableRepository;
use Doctrine\DBAL\DBALException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    /**
     * @var RemoteTableColumnRepository
     */
    private $remoteTableColumnRepository;

    public function __construct(
        RemoteTableRepository $remoteTableRepository,
        RemoteTableColumnRepository $remoteTableColumnRepository,
        ConnectionByDataBaseFactory $connectionByDataBaseFactory
    ) {

        $this->remoteTableRepository = $remoteTableRepository;
        $this->connectionByDataBaseFactory = $connectionByDataBaseFactory;
        $this->remoteTableColumnRepository = $remoteTableColumnRepository;
    }

    /**
     * @Route("/config/table/{tableId}", name="configTable")
     * @param Request $request
     * @param $tableId
     * @return Response
     */
    public function configTable(Request $request, $tableId)
    {
        $table = $this->remoteTableRepository->find($tableId);

        $form = $this->createForm(RemoteTableType::class, $table, ['method' => RemoteTableType::METHOD_EDIT_TYPE]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $dataBase = $form->getData();
            $this->remoteTableRepository->save($dataBase);

            //return $this->redirect("/dataBase/list");
        }

        return $this->render('config/table.html.twig', [
            'form' => $form->createView(),
            'table' => $table,
            'edit' => true
        ]);
    }

    /**
     * @Route("/config/columns/{tableId}", name="configColumns")
     * @param $tableId
     * @return Response
     * @throws DBALException
     */
    public function configColumns($tableId)
    {
        $table = $this->remoteTableRepository->find($tableId);

        $connection = $this->connectionByDataBaseFactory->createConnection($table->getDatabase());
        $table->setConnection($connection);

        return $this->render('config/columns.html.twig', [
            'columns' => $table->getColumns()
        ]);
    }

    /**
     * @Route("/config/column/{columnId}", name="configColumn")
     * @param $columnId
     * @return Response
     * @throws DBALException
     */
    public function configColumn($columnId)
    {
        $column = $this->remoteTableColumnRepository->find($columnId);

        return $this->render('config/column.html.twig', [
            'column' => $column
        ]);
    }

}