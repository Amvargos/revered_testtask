<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraficLightLog extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'message',
        'light_color',
        'previous_light_color'
    ];
}
