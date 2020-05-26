<?php

namespace App\Models;

use App\Models\Message;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;

class Message extends Model
{
    // use Notifiable;
    protected $table = 'message';

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'actiontime' => 'datetime',
    ];
}
