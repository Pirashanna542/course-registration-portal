<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = ['course_id', 'name', 'email', 'phone'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}