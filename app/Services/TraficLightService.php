<?php
namespace App\Services;

use App\Events\ChangeTraficLightEvent;
use App\Events\UpdateTraficLightLogEvent;
use Illuminate\Http\JsonResponse;
use Nwidart\Modules\Json;
use App\Repositories\TraficLightLogRepository;
class TraficLightService
{
    public function __construct(
        TraficLightLogRepository $traficLightLogRepository
    ){
        $this->traficLightLogRepository = $traficLightLogRepository;
    }

    /**
     * Получение всех записей в логе о светофоре
     *
     * @return mixed
     */
    public function getTraficLightLog(){
        return $this->traficLightLogRepository->all();
    }

    /**
     * Проверяет состояние светофоров.
     *
     * @return void
     */
    public function checkTraficLights(): void
    {
        $startTime = time();
        $maxExecutionTime = 59;

        while (true) {
            if (time() - $startTime >= $maxExecutionTime) {
                break;
            }

            $color = $this->calculateTraficLightColor();
            ChangeTraficLightEvent::dispatch(['light' => $color]);
        }
    }

    /**
     * Запускает движение автомобиля в соответствии с текущим цветом светофора.
     *
     * @return void
     */
    public function go(): void
    {
        $color = $this->calculateTraficLightColor('index');
        $message = $this->getMessageForColor($color);
        UpdateTraficLightLogEvent::dispatch(['message' => $message]);
        $this->createLog($message);
    }

    /**
     * Вычисляет текущий цвет светофора.
     *
     * @return string
     */
    private function calculateTraficLightColor($type = 'color'): string
    {
        $baseTime = strtotime('01.01.1970 00:00');
        $timeInCycle = (time() - $baseTime) % (5 + 2 + 5 + 2);
        $colors = ['green', 'yellow', 'red', 'yellow'];
        $colorIndex = intval($timeInCycle / (5 + 2 + 5 + 2) * count($colors));
        if($type === 'index') {
            return $colorIndex;
        }else{
            return $colors[$colorIndex];
        }
    }

    /**
     * Возвращает сообщение в зависимости от цвета светофора.
     *
     * @param string $color
     * @return string
     */
    private function getMessageForColor(string $color): string
    {
        switch ($color) {
            case 0:
                return 'Проезд на зеленый!';
            case 1:
                return 'Успели на желтый!';
            case 2:
                return 'Проезд на красный. Штраф!';
            case 3:
                return 'Слишком рано начали движение!';
        }
    }

    
    /**
     * Отправляем запись о логе в базу
     *
     * @param string $message
     * @return void
     */
    private function createLog($message){
        $this->traficLightLogRepository->create($message);
    }

}
