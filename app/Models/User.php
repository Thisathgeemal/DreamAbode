<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
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
        'profile_image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active'         => 'boolean',
        'dob'               => 'date',
        'user_roles'        => 'array',
    ];

    /**
     * Mutator to hash passwords automatically when set
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'member_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'member_id', 'id');
    }

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
