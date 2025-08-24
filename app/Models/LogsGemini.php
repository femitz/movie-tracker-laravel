<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogsGemini extends Model
{
    protected $table = 'logs_gemini';
    protected $fillable = ['prompt', 'response', 'response_text', 'id_user', 'model'];
}
