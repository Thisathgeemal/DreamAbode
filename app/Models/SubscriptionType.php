<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionType extends Model
{
    use HasFactory;

    protected $table      = 'subscription_types';
    protected $primaryKey = 'type_id';

    protected $fillable = [
        'type_name',
        'duration_days',
        'base_amount',
        'discount_percent',
        'final_price',
    ];

    protected $casts = [
        'duration_days'    => 'integer',
        'base_amount'      => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'final_price'      => 'decimal:2',
    ];

    public $timestamps = true;

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'type_id', 'type_id');
    }
}
