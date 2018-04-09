<?php

namespace App\Diablo3;
use Illuminate\Support\Facades\Storage;

class Util
{

    /**
     *
     *
     * @param
     * @return
     */
    public static function riftTime($time)
    {
        return date("i분 s", substr($time, 0, 3)). "." .substr($time, 3, 3)."초";
    }

    /**
     *
     *
     * @param
     * @return
     */
    public static function completeTime($time)
    {
        return date("Y. m. d H:i:s", $time / 1000);
    }

    /**
     *
     *
     * @param
     * @return
     */
    public static function getIndex($type='current_season')
    {
        $getIndex = Storage::get('currentIndex');
        $aIndex = json_decode($getIndex, true);
        return $aIndex[$type];
    }
}
