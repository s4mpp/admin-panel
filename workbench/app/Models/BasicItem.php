<?php

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicItem extends Model
{
    use HasFactory;

    protected $casts = [
        'basic_date' => 'date'
    ];
}
