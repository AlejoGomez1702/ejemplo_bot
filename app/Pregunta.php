<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $fillable = [
        'enunciado', 'respuesta',
    'opcion1', 'opcion2', 'opcion3', 'opcion4'
    ];
    
    //Una pregunta pertenece unicamente a un quiz.
    public function quiz()
    {
        return $this->belongsTo('App\Quiz');
    }


}
