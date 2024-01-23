<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Auth;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Vendor;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $guard_name = 'web';
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'is_active',
    ];
    protected $appends = [];
    protected $guarded = [];
    protected $dates = [
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'integer',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $visible = [
    ];
    protected $attributes = [
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($data) {
            $data->uid = Uuid::uuid4();
        });

        self::updating(function ($data) {
        });
    }

    protected function username(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: fn ($value) => empty($value) ? null : $value
        );
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
