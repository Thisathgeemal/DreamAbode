<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectAd extends Model
{
    use HasFactory;

    protected $table      = 'project_ads';
    protected $primaryKey = 'project_id';

    protected $fillable = [
        'agent_id',
        'admin_id',
        'member_id',
        'buyer_ids',
        'project_name',
        'property_type',
        'location',
        'total_units',
        'available_units',
        'bedrooms',
        'bathrooms',
        'parking_spaces',
        'measurement',
        'price',
        'project_status',
        'status',
        'completion_date',
    ];

    protected $casts = [
        'total_units'     => 'integer',
        'available_units' => 'integer',
        'bedrooms'        => 'integer',
        'bathrooms'       => 'integer',
        'parking_spaces'  => 'integer',
        'measurement'     => 'decimal:2',
        'price'           => 'decimal:2',
        'completion_date' => 'date:Y-m-d',
        'buyer_ids'       => 'array',
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
        return $this->hasMany(Image::class, 'project_id', 'project_id');
    }

    public function buyers()
    {
        return User::whereIn('id', $this->buyer_ids ?? [])->get();
    }
}
