<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Yuming extends Model
{
    protected  $table ='yuming';

    public static function gettitle($host)
    {
        return Yuming::where(['host'=>$host])->first()->webname;
    }

    public static function getkeyword($host)
    {
        return Yuming::where(['host'=>$host])->first()->keyword;
    }

    public static function getdescription($host)
    {
        return Yuming::where(['host'=>$host])->first()->description;
    }

}
