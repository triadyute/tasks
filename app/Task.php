<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name', 'completed', 'priority'];

    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
