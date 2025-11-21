<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequirmentSubmited extends Model
{
    //

    protected $table = 'student_requirment_sub';

    protected $fillable = [
        'requestor_name',
        'teacher_or_office',
        'section',
        'course',
        'drive_link',
        'image',
        'student_id',
    ];
}
