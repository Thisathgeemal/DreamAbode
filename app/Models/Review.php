<?php
namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'reviews';

    protected $fillable = [
        'member_id',
        'rating',
        'description',
        'visibility',
    ];

    protected $casts = [
        'rating'     => 'integer',
        'visibility' => 'boolean',
    ];

    public $timestamps = true;

}
