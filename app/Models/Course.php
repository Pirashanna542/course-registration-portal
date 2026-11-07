
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['title', 'description', 'duration'];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}