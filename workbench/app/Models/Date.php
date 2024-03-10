<?php

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    use HasFactory;

    protected $casts = [
        'basic_date' => 'date',
        'basic_datetime' => 'datetime'
    ];
}
