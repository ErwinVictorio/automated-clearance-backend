<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annoucement extends Model
{
      protected $table = 'annoucements';

    protected $fillable = [
       'teacher_or_office_id',
       'message',
        'title'
    ];


    public function user(){ // kung ano nalagay dito yon lalagay mo sa with mo

        return $this->belongsTo(User::class,'teacher_or_office_id');
    }


    
}
