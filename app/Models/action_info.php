<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class action_info extends Model
{
    // use Notifiable;
    protected $table = 'action_info';

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message_id', 'sysid', 'svrid', 'subsysid', 'cmpid', 'phoneq', 'mailq', 'wechatq', 'ssmq'
    ];
}
