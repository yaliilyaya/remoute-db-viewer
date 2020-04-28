<?php


namespace App\Controller\DataBaseConnect;

use App\Factory\ConnectionByDataBaseFactory;
use App\Form\Type\RemoteTableColumnType;
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