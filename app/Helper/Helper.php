<?php


namespace App\Helper;


class Helper
{
    static function generateRandomString($length = 8)
    {
        $characters = '23456789abcdefghkmnprstuvwxyzABCDEFGHKMNPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
