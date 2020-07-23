<?php


namespace App\Controller\Editor;

use App\Repository\RemoteTableRepository;
use App\Service\ImportExport\TableExtractDataService;
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

    public function __construct(
        RemoteTableRepository $remoteTableRepository,
        TableExtractDataService $tableExtractDataService
    ) {
        $this->remoteTableRepository = $remoteTableRepository;
        $this->tableExtractDataService = $tableExtractDataService;
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