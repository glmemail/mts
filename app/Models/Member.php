<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'member';

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'userid', 'fluentd_key', 'mail_addr', 'phone_number', 'wechat_id', 'gender', 'created_at', 'updated_at'
    ];
}
