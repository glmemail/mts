<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aliivr extends Model
{
    // use Notifiable;
    protected $table = 'aliivr';
    public $timestamps = false;
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'call_id', 'start_time', 'end_time', 'duration', 'status_time', 'status_time', 'status_msg', 'out_id', 'dtmf'
    ];
}
