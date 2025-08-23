<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table      = 'reviews';
    protected $primaryKey = 'review_id';

    protected $fillable = [
        'member_id',
        'rating',
        'description',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public $timestamps = true;

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id', 'id');
    }
}
