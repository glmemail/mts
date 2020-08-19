<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message_list extends Model
{
    // use Notifiable;
    protected $table = 'message_list';

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message' => 'json',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

}
