<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\PreRequisite;

class SchemeDocument extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Get the pre-requisite associated with this document id
     */
    public function pre_requisite()
    {
        return $this->hasOne(PreRequisite::class, "id", "prerequisite_id");
    }
}
