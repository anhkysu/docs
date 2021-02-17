<?php
/**
 * Created by PhpStorm.
 * User: macintosh
 * Date: 11/24/18
 * Time: 5:15 PM
 */

namespace App;


class NavigateClass
{
    public static function getInstance($className, $params = []){
        $nameSpace = str_replace('_', '\\' ,$className);
        $nameSpace = 'App\\' . $nameSpace;

        $reflection_class = new \ReflectionClass($nameSpace);
        return $reflection_class->newInstanceArgs($params);
    }
}