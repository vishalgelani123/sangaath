<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\SchemeDocument;
use App\Models\SchemeRule;

class Scheme extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Get the documents associated with the schemes
     */
    public function documents()
    {
        return $this->hasMany(SchemeDocument::class, "scheme_id", "id");
    }

    /**
     * Get the rules associated with the schemes
     */
    public function rules()
    {
        return $this->hasMany(SchemeRule::class, "scheme_id", "id");
    }

    public function format()
    {
        $category = $this->category;
        $this->display_category = ucwords($category);

        $documents = $this->documents->pluck("prerequisite_id")->toArray();
        $this->documents_id = $documents;

        return $this;
    }
}
