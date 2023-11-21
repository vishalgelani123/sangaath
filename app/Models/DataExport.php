<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\Models\Site;
use App\Models\Village;

class DataExport extends Model
{
    use HasFactory;

    public function site()
    {
        return $this->hasOne(Site::class, "id", "site_id");
    }

    public function village()
    {
        return $this->hasOne(Village::class, "id", "village_id");
    }

    public function format()
    {
        if ($this->start_date) {
            $this->start_date = Carbon::parse($this->start_date)->format("d M Y");
            $this->end_date = Carbon::parse($this->end_date)->format("d M Y");
        }

        $this->exported_at = $this->created_at->format("d M Y h:i");
        return $this;
    }
}
