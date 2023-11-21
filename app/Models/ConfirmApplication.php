<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use App\Models\Scheme;
use App\Models\Beneficiary;
use App\Models\Village;

class ConfirmApplication extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Get the scheme associated with the application
     */
    public function scheme()
    {
        return $this->hasOne(Scheme::class, "id", "scheme_id");
    }

    /**
     * Get the village associated with the application
     */
    public function village()
    {
        return $this->hasOne(Village::class, "id", "village_id");
    }

    /**
     * Get the beneficiary associated with the form
     */
    public function beneficiary()
    {
        return $this->hasOne(Beneficiary::class, "member_id", "member_id");
    }

    public function format()
    {
        if ($this->documentation_date != null) {
            $documentationDate = date("d M Y", strtotime($this->documentation_date));
            $this->documentation_date = $documentationDate;
        }

        if ($this->liasoning_date != null) {
            $liasoningDate = date("d M Y", strtotime($this->liasoning_date));
            $this->liasoning_date = $liasoningDate;
        }

        if ($this->govt_submission_date != null) {
            $govtSubmissionDate = date("d M Y", strtotime($this->govt_submission_date));
            $this->govt_submission_date = $govtSubmissionDate;
        }

        if ($this->govt_submission_status == 1 && $this->benefit_status == 0) {
            $normalFollowupDays = intval($this->scheme->followup_days);
            $followupDate = $this->followup_date;
            $todayDate = date("Y-m-d");

            $startDate = strtotime($followupDate);
            $endDate = strtotime($todayDate);
            $extraDays = ($endDate - $startDate) / 60 / 60 / 24;
            if ($extraDays > 0) {
                $normalFollowupDays += $extraDays;
            }
            $this->followup_days = $normalFollowupDays;
        }

        $this->applied_date = $this->created_at->format("d M Y");

        return $this;
    }
}
