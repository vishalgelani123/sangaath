<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use App\Models\Beneficiary;
use App\Models\Scheme;
use App\Models\Village;

class IncompleteForm extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Get the beneficiary associated with the form
     */
    public function beneficiary()
    {
        return $this->hasOne(Beneficiary::class, "member_id", "member_id");
    }

    /**
     * Get the scheme associated with the form
     */
    public function scheme()
    {
        return $this->hasOne(Scheme::class, "id", "scheme_id");
    }

    /**
     * Get the village associated with the form
     */
    public function village()
    {
        return $this->hasOne(Village::class, "id", "village_id");
    }
}
