<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table      = 'images';
    protected $primaryKey = 'image_id';

    protected $fillable = [
        'property_id',
        'project_id',
        'image_path',
    ];

    public $timestamps = true;

    public function property()
    {
        return $this->belongsTo(PropertyAd::class, 'property_id', 'property_id');
    }

    public function project()
    {
        return $this->belongsTo(ProjectAd::class, 'project_id', 'project_id');
    }
}
