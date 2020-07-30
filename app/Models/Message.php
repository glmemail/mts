<?php

namespace App\Models;

// use App\Models\Message;
use Illuminate\Database\Eloquent\Model;
use App\Models\Action_info;
use Encore\Admin\Facades\Admin;

class Message extends Model
{
    // public function action()
    // {
    //     return $this->hasMany(Action_info::class, 'message_id', 'id');
    // }

    // use Notifiable;
    protected $table = 'message';

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
