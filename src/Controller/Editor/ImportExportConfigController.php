<?php


namespace App\Controller\Editor;

use App\Repository\RemoteTableRepository;
use App\Service\ImportExport\ColumnImportService;
use App\Service\ImportExport\DecoratorImportService;
use App\Service\ImportExport\RelationImportService;
use App\Service\ImportExport\TableExtractDataService;
use App\Service\ImportExport\TableImportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ImportExportConfigController
 * @package App\Controller\Editor
 */
class ImportExportConfigController extends AbstractController
{

    /**
     * @var RemoteTableRepository
     */
    private $remoteTableRepository;
    /**
     * @var TableExtractDataService
     */
    private $tableExtractDataService;
    /**
     * @var TableImportService
     */
    private $tableImportService;
    /**
     * @var ColumnImportService
     */
    private $columnImportService;
    /**
     * @var DecoratorImportService
     */
    private $decoratorImportService;
    /**
     * @var RelationImportService
     */
    private $relationImportService;

    public function __construct(
        RemoteTableRepository $remoteTableRepository,
        TableExtractDataService $tableExtractDataService,
        TableImportService $tableImportService,
        ColumnImportService $columnImportService,
        DecoratorImportService $decoratorImportService,
        RelationImportService $relationImportService
    ) {
        $this->remoteTableRepository = $remoteTableRepository;
        $this->tableExtractDataService = $tableExtractDataService;

        $this->tableImportService = $tableImportService;
        $this->columnImportService = $columnImportService;
        $this->decoratorImportService = $decoratorImportService;
        $this->relationImportService = $relationImportService;
    }

    /**
     * @Route("/importExport/view")
     * @return Response
     */
    public function view(): Response
    {
        return $this->render('importExport/view.twig');
    }
    /**
     * @Route("/importExport/import", name="configImport")
     * @return Response
     */
    public function import(): Response
    {
        $tables = [];

        $this->tableImportService->tableImport($tables);
        $this->columnImportService->columnImport($tables);
        $this->decoratorImportService->decoratorImport($tables);
        $this->relationImportService->relationImport($tables);

        return $this->render('importExport/import.twig');
    }

    /**
     * @Route("/importExport/export", name="configExport")
     * @return Response
     */
    public function export(): Response
    {
        $tables = $this->remoteTableRepository->findAll();
        $tableData = $this->tableExtractDataService->getData($tables);

        $response = new JsonResponse();
        $response->setData(['tables' => $tableData]);

        return $response;
    }
}