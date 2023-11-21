<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Site;
use App\Models\Uservillage;

class User extends Authenticatable
{
    use HasRoles;
    use SoftDeletes;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the site allocated to the user
     */
    public function site()
    {
        return $this->hasOne(Site::class, "id", "site_id");
    }

//    public function sites()
//    {
//        $siteIds = json_decode($this->site_id, true); // Convert JSON-encoded array to actual array
//        return $this->hasMany(Site::class, 'id', 'site_id')
//            ->whereIn('id', $siteIds);
//    }

    /**
     * Get the villages allocated to the user
     */
    public function villages()
    {
        return $this->hasMany(Uservillage::class, "user_id", "id")->whereHas("village_name");
    }

    public function format()
    {
        $createdAt = $this->created_at->format("d M Y");
        $this->create_date = $createdAt;
        if ($this->villages != null) {
            $this->selected_villages = $this->villages->pluck("village_id")->toArray();
        }

        $role = "";
        if ($this->hasRole('admin')) {
            $role = "master_admin";
        } else if ($this->hasRole("project_coordinator")) {
            $role = "project_coordinator";
        } else if ($this->hasRole("supervisor")) {
            $role = "supervisor";
        } else if ($this->hasRole("facilitator")) {
            $role = "facilitator";
        } else if ($this->hasRole("sub_admin")) {
            $role = "sub_admin";
        } else if ($this->hasRole("report_admin")) {
            $role = "report_admin";
        }
        $this->role = $role;
        $this->display_role = ucwords(str_replace("_", " ", $role));

        return $this;
    }
}
