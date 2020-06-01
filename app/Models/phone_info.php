<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class phone_info extends Model
{
    // use Notifiable;
    protected $table = 'phone_info';

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sysid', 'svrid', 'subsysid', 'cmpid', 'rule_cond', 'phone_number', 'requestid', 'code', 'message', 'actiontime'
    ];
}
