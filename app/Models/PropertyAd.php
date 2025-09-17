<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyAd extends Model
{
    use HasFactory;

    protected $table      = 'property_ads';
    protected $primaryKey = 'property_id';

    protected $fillable = [
        'agent_id',
        'admin_id',
        'member_id',
        'buyer_id',
        'property_name',
        'property_type',
        'location',
        'measurement',
        'perches',
        'bedrooms',
        'bathrooms',
        'floors',
        'price',
        'post_type',
        'status',
    ];

    protected $casts = [
        'measurement' => 'decimal:2',
        'perches'     => 'decimal:2',
        'bedrooms'    => 'integer',
        'bathrooms'   => 'integer',
        'floors'      => 'integer',
        'price'       => 'decimal:2',
    ];

    public $timestamps = true;

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id', 'id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'id');
    }

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'property_id', 'property_id');
    }
}
