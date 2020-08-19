<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Message;

class Action_info extends Model
{

    public function message()
    {
        return $this->belongsTo(Message::class, 'id', 'message_id');
    }

    // use Notifiable;
    protected $table = 'action_info';

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message_id', 'code1', 'code2', 'code3', 'code4', 'code5', 'code6', 'actiontype', 'actiontime'
    ];
}
