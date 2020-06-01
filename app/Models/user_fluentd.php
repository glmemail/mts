<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class user_fluentd extends Model
{
    // use Notifiable;
    protected $table = 'user_fluentd';

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'fluentd_keyid'
    ];
}
