<?php
namespace App\Repositories;

use App\Models\TraficLightLog;

class TraficLightLogRepository
{
    /**
     * Получение массива всех записей лога
     *
     * @return mixed
     */
    public function all()
    {
        return TraficLightLog::orderBy('id','desc')->get();
    }

    /**
     * Создание сообшения лога
     *
     * @param $message
     * @return void
     */
    public function create($message){
        TraficLightLog::create([
            'message' => $message,
        ]);
    }
}
