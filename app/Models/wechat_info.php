<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class wechat_info extends Model
{
    // use Notifiable;
    protected $table = 'wechat_info';

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sysid', 'svrid', 'subsysid', 'cmpid', 'wechat_to', 'qy_id', 'qy_secret', 'qy_agent_id', 'group_flg', 'contact_name', 'actiontime'
    ];
}
