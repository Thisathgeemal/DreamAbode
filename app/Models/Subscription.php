<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table      = 'subscriptions';
    protected $primaryKey = 'subscription_id';

    protected $fillable = [
        'member_id',
        'type_id',
        'start_date',
        'end_date',
        'status',
        'payment_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'status'     => 'string',
    ];

    public $timestamps = true;

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id', 'id');
    }

    public function subscriptionType()
    {
        return $this->belongsTo(SubscriptionType::class, 'type_id', 'type_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'payment_id');
    }
}
