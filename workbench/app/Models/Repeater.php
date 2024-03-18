<?php

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Model;
use Workbench\App\Models\ChildRepeater;
use Workbench\App\Models\OtherChildRepeater;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Repeater extends Model
{
    use HasFactory;

    public function childRepeaters()
    {
        return $this->hasMany(ChildRepeater::class, 'main_repeater_id');
    }

    public function otherChildRepeaters()
    {
        return $this->hasMany(OtherChildRepeater::class, 'main_repeater_id');
    }
}
