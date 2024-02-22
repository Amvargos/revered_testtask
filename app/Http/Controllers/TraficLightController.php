<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Services\TraficLightService;
use App\Models\TraficLightLog;

class TraficLightController extends Controller {
    
    public function __construct(
        TraficLightService $traficLightService
    ){
        $this->traficLightService = $traficLightService;
    }

    /**
     * Рендер главной страницы светофора
     *
     * @return Response
     */
    public function index(): Response
    {
        $logs = $this->traficLightService->getTraficLightLog();
        return Inertia::render('Dashboard', [
            'logs' => $logs,
        ]);
    }

    /**
     * Обработка кнопки "Вперёд"
     *
     * @return mixed
     */
    public function go()
    {
        return $this->traficLightService->go();
    }
}
