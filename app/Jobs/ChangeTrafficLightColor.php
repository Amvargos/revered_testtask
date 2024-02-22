<?php

namespace App\Jobs;

use App\Services\TrafficLightService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ChangeTrafficLightColor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $trafficLightService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TrafficLightService $trafficLightService)
    {
        $this->trafficLightService = $trafficLightService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $nextColor = $this->trafficLightService->getNextColor();
        // Далее можно вызвать нужные действия в зависимости от цвета светофора
        // Например, обновление состояния светофора в базе данных или отправка уведомления пользователям.
    }
}
