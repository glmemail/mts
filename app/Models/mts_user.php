<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mts_user extends Model
{
    // use Notifiable;
    protected $table = 'user';

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'userid', 'username', 'password', 'roleid', 'cmpid', 'depid', 'sysflag'
    ];
}
