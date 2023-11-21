<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Beneficiary;
use App\Models\Village;
use App\Models\PreRequisite;

class kycDocument extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Get the member associated with the document
     */
    public function member()
    {
        return $this->hasOne(Beneficiary::class, "member_id", "member_id");
    }

    /**
     * Get the village associated with the document
     */
    public function village()
    {
        return $this->hasOne(Village::class, "id", "village_id");
    }

    /**
     * Get the Pre-Requisite associated with the document
     */
    public function pre_requisite()
    {
        return $this->hasOne(PreRequisite::class, "id", "prerequisite_id");
    }
}
