<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequirmentModel extends Model
{
    //

    protected  $table='requirements';

     protected  $fillable = [
       'title',
       'detail',
       'subject',
       'teacher_id'
    ];


    public function teacher(){

        return $this->belongsTo(User::class,'teacher_id');
    }

}
