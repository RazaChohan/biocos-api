<?php

if ( ! function_exists('config_path'))
{
    /**
     * Get the configuration path.
     *
     * @param  string $path
     * @return string
     */
    function config_path($path = '')
    {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
    /**
     * Check if given string is null or empty.
     *
     * @param  string $string
     * @return bool
     */
    function IsNullOrEmptyString($string){
        return (!isset($string) || trim($string)=='');
    }
}

if (!function_exists('public_path')) {
    /**
     * Return the path to public dir
     *
     * @param null $path
     *
     * @return string
     */
    function public_path($path = null)
    {
        return rtrim(app()->basePath('public/' . $path), '/');
    }
}

function getParam($array, $key){
    return isset($array[$key]) ? $array[$key] : null;
}

if (!function_exists('urlGenerator')) {
    /**
     * @return \Laravel\Lumen\Routing\UrlGenerator
     */
    function urlGenerator() {
        return new \Laravel\Lumen\Routing\UrlGenerator(app());
    }
}

if (!function_exists('asset')) {
    /**
     * @param $path
     * @param bool $secured
     *
     * @return string
     */
    function asset($path, $secured = false) {
        return urlGenerator()->asset($path, $secured);
    }
}

/**
 * Sort Question Array
 *
 * @param $a
 * @param $b
 * @return bool
 */
function cmp($a, $b) {
    return $a->question_id > $b->question_id;
}

/***
 * Create recursive path with mod 777
 *
 * @param $path
 * @return bool
 */
function createPath($path) {
    return (file_exists($path)) ? true : mkdir($path, 07777, true);
}


function calculate_offset($page, $itemsPerPage = 10) {
    $offset = ($page - 1) * $itemsPerPage;
    return $offset;
}

function getEnumValues($tableName, $fieldName){
    $type = \DB::select(\DB::raw("SHOW COLUMNS FROM $tableName WHERE Field = '$fieldName'"))[0]->Type;
    preg_match('/^enum\((.*)\)$/', $type, $matches);
    $values = array();
    foreach(explode(',', $matches[1]) as $value){
        $values[] = trim($value, "'");
    }
    return $values;
}

function setDiscountPercentageArrayConstants($discountPercentageConst) {
    $discountPercentageMapping = [
            'wholesaler' => '< 10',
            'retail saler' => '<= 4'
    ];
    $newConstants = [];
    foreach($discountPercentageConst as $constant){
        $object = new \stdClass();
        $object->{$constant} = array_key_exists($constant, $discountPercentageMapping) ?
                                $discountPercentageMapping[$constant] : "";
        $newConstants[] = $object;
    }
    return $newConstants;
}