<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TodoMirror extends Model
{
    protected $table = 'todo_mirrors';
    protected $fillable = ['name','desc'];
}
