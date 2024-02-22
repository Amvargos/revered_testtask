<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\ChangeTraficLightEvent;
use App\Services\TraficLightService;
use App\Repositories\TraficLightLogRepository;
use Illuminate\Support\Facades\App;

class CheckTraficLight extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CheckTraficLight';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */ 
    public function handle()
    {
        app(TraficLightService::class)->checkTraficLights();
    }
}
