<?php


namespace App\Helpers;


class ArrayHelper
{
    public static function getColumn(array $array, string $neededKey){
        $result = [];
        foreach ($array as $arrValue){
            foreach ($arrValue as $key => $value) {
                if($key == $neededKey){
                    $result[] = $value;
                }
            }
        }
        return $result;
    }
}
