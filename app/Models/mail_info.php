<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mail_info extends Model
{
    // use Notifiable;
    protected $table = 'mail_info';

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sysid', 'svrid', 'subsysid', 'cmpid', 'mail_to', 'mail_from', 'contact_name', 'actiontime'
    ];
}
