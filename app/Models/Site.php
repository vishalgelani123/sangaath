<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Village;

use Carbon\Carbon;

class Site extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * Get the villages associated with the site
     */
    public function villages()
    {
        return $this->hasMany(Village::class, "site_id", "id");
    }

    public function format()
    {
        $createdAt = $this->created_at->format("d M Y");
        $this->create_date = $createdAt;
        $this->display_state = ucwords(str_replace("_", " ", $this->state));

        return $this;
    }
}
