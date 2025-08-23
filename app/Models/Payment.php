<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table      = 'payments';
    protected $primaryKey = 'payment_id';

    protected $fillable = [
        'member_id',
        'amount',
        'description',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public $timestamps = true;

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id', 'id');
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class, 'payment_id', 'payment_id');
    }
}
