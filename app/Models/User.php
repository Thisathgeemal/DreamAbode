<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile_number',
        'address',
        'gender',
        'dob',
        'user_roles',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'dob'               => 'date',
        'is_active'         => 'boolean',
        'user_roles'        => 'array',
    ];

    /**
     * Mutator to hash passwords automatically when set
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    protected function dob(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? Carbon::parse($value)->format('Y-m-d') : null,
            set: fn($value) => $value ? Carbon::parse($value)->format('Y-m-d') : null
        );
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'member_id', 'id');
    }

    // public function reviews()
    // {
    //     return $this->hasMany(Review::class, 'member_id', 'id');
    // }

    public function propertyAds()
    {
        return $this->hasMany(PropertyAd::class, 'member_id', 'id');
    }

    public function propertyAgents()
    {
        return $this->hasMany(PropertyAd::class, 'agent_id', 'id');
    }

    public function propertyAdmin()
    {
        return $this->hasMany(PropertyAd::class, 'admin_id', 'id');
    }

    public function propertyBuyer()
    {
        return $this->hasMany(PropertyAd::class, 'buyer_id', 'id');
    }

    public function projectAds()
    {
        return $this->hasMany(ProjectAd::class, 'member_id', 'id');
    }

    public function projectAgents()
    {
        return $this->hasMany(ProjectAd::class, 'agent_id', 'id');
    }

    public function projectAdmin()
    {
        return $this->hasMany(ProjectAd::class, 'admin_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'member_id', 'id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'id');
    }

    public function chatMessagesSent()
    {
        return $this->hasMany(ChatMessage::class, 'sender_id', 'id');
    }

    public function chatMessagesReceived()
    {
        return $this->hasMany(ChatMessage::class, 'receiver_id', 'id');
    }

}
