<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Village;
use App\Models\Beneficiary;

class Household extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    /**
     * Get the village associated with the household
     */
    public function village()
    {
        return $this->hasOne(Village::class, "id", "village_id");
    }

    /**
     * Get the members associated with the household
     */
    public function members()
    {
        return $this->hasMany(Beneficiary::class, "hh_id", "hh_id");
    }

    public function format()
    {
        $this->register_date = $this->created_at->format("d M Y");

        return $this;
    }
}
