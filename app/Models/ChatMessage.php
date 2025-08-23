<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $table      = 'chat_messages';
    protected $primaryKey = 'chat_id';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'is_read',
        'deleted_by_sender_at',
        'deleted_by_receiver_at',
    ];

    protected $casts = [
        'is_read'                => 'boolean',
        'deleted_by_sender_at'   => 'datetime',
        'deleted_by_receiver_at' => 'datetime',
    ];

    public $timestamps = true;

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }
}
