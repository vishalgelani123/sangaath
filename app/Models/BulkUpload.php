<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkUpload extends Model
{
    use HasFactory;

    /**
     * Formats the bulk upload instance in the required format
     * 
     * @return \App\Models\BulkUpload
     */
    public function format()
    {
        $this->file_type = $this->type == "hh_head" ? "Household Head" : "Individual Members";
        $this->uploaded_at = $this->created_at->format("d M Y h:i");
        $this->download_link = env("APP_ENV") == "local" ? "/uploads/".$this->file_name : "/uploads/".$this->file_name;

        return $this;
    }
}
