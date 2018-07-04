<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Novel extends Model
{
    protected $table = 'novel';

    public static function getnovel($navid,$count='')
    {
        if (empty($count)){
            return Novel::where(['navid'=>$navid])->get();
        }else{
            return Novel::where(['navid'=>$navid])->take($count)->get();
        }
    }

}
