<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fluentd extends Model
{
    // use Notifiable;
    protected $table = 'fluentd';

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'keyname', 'sysid', 'svrid', 'subsysid', 'cmpid', 'phoneq', 'mailq', 'wechatq', 'ssmq'
    ];
}
