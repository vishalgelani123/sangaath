<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Site;

class Village extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Get the site associated with the village
     */
    public function site()
    {
        return $this->hasOne(Site::class, "id", "site_id");
    }

    public function format()
    {
        $createdAt = $this->created_at->format("d M Y");
        $this->create_date = $createdAt;
        $this->display_state = ucwords(str_replace("_", " ", $this->state));

        return $this;
    }
}
