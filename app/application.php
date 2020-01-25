<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class application extends Model
{
    protected $table = 'applications';
    protected $fillable = ['name','icon'];
}
