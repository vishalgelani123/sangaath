<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Village;
use App\Models\Household;

class Beneficiary extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    /**
     * Get the village associated with the beneficiary
     */
    public function village()
    {
        return $this->hasOne(Village::class, "id", "village_id");
    }

    /**
     * Get the household associated with the beneficiary
     */
    public function household()
    {
        return $this->hasOne(Household::class, "hh_id", "hh_id");
    }

    public function checkIncompleteData()
    {
        $isIncomplete = false;

        if ($this->gender == null) {
            $isIncomplete = true;
            // dd("Gender");
        }else if ($this->marital_status == null) {
            $isIncomplete = true;
            // dd("marital_status");
        }else if ($this->disability == null) {
            $isIncomplete = true;
            // dd("disability_status");
        }else if ($this->type_of_house == null) {
            $isIncomplete = true;
            // dd("type_of_house");
        }else if ($this->land_ownership != 0 && ($this->aadhaar_card == null || $this->aadhaar_card == -1)) {
            $isIncomplete = true;
            // dd("aadhaar_card");
        }else if ($this->land_ownership != 0 && ($this->bank_account == null || $this->bank_account == -1)) {
            $isIncomplete = true;
            // dd("bank_account");
        }else if ($this->land_ownership != 0 && ($this->election_card == null || $this->election_card == -1)) {
            $isIncomplete = true;
            // dd("election_card");
        }else if ($this->widow_status == null) {
            $isIncomplete = true;
            // dd("widow_status");
        }else if ($this->land_ownership != 0 && ($this->land_ownership == null || $this->land_ownership == -1)) {
            $isIncomplete = true;
            // dd("land_ownership");
        }else if ($this->income == null) {
            $isIncomplete = true;
            // dd("land_ownership");
        }

        $this->is_data_incomplete = $isIncomplete;
        return $this;
    }
}
