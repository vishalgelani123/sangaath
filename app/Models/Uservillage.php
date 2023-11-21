<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Village;

class Uservillage extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Get the village allocated to the id
     */
    public function village_name()
    {
        return $this->hasOne(Village::class, "id", "village_id");
    }
}
