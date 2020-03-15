<?php

namespace App\Controller;

use App\Service\DynamicDataBaseNamesService;
use App\Service\DynamicTableNamesService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController
{
    /**
     * @var DynamicDataBaseNamesService
     */
    private $dynamicDataBaseNamesService;
    /**
     * @var DynamicTableNamesService
     */
    private $dynamicTableNamesService;

    public function __construct(
        DynamicDataBaseNamesService $dynamicDataBaseNamesService,
        DynamicTableNamesService $dynamicTableNamesService)
    {
        $this->dynamicDataBaseNamesService = $dynamicDataBaseNamesService;
        $this->dynamicTableNamesService = $dynamicTableNamesService;
    }

    /**
    * @Route("/")
    */
    public function index()
    {
        $this->dynamicDataBaseNamesService->getNames('');

        dump($this->dynamicTableNamesService->getNames(''));

        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
}