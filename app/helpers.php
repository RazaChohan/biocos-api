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

/***
 * Set discount percentage array constants
 *
 * @param $discountPercentageConst
 * @return array
 */
function setDiscountPercentageArrayConstants($discountPercentageConst) {
    $discountPercentageMapping = [
            'Wholesaler' => '< 10',
            'Retail Saler' => '<= 4'
    ];
    $newConstants = [];
    foreach($discountPercentageConst as $constant){
        $object = new \stdClass();
        $object->discount_type = $constant;
        $object->discount_percentage = array_key_exists($constant, $discountPercentageMapping) ?
                                $discountPercentageMapping[$constant] : "";
        $newConstants[] = $object;
    }
    return $newConstants;
}

/****
 * Upload base64 image
 *
 * @param string $base64EncodeString
 * @param string $path
 * @param string $imageNamePrefix
 * @param bool $fetchNameOnly
 * @return null|string
 */
function upload_base64_image($base64EncodeString = '',$path = 'images', $imageNamePrefix = 'userimage-', $fetchNameOnly = false)
{
    try {
        $decodedFile = base64_decode($base64EncodeString);
        $opeFileToGetInfo = finfo_open();
        $fileExtension = explode('/', finfo_buffer($opeFileToGetInfo, $decodedFile, FILEINFO_MIME_TYPE))[1];

        $image_name = $imageNamePrefix . time() . str_random(4)."." . $fileExtension;
        $imagePath = public_path($path) . "/" . $image_name;
        createPath(public_path($path));
        file_put_contents($imagePath, $decodedFile);
        return ($fetchNameOnly) ? $image_name : env('APP_URL') . '/' . $path . $image_name;

    } catch (Exception $ex) {
        return null;
    }
}
/***
 * Get filename from url
 *
 * @param $url
 * @return null
 */
function get_filename_url($url) {
    $filename = null;
    if(!IsNullOrEmptyString($url)) {
        $path = parse_url($url, PHP_URL_PATH);
        $path = explode('/', $path);
        $filename = $path[sizeof($path) - 1];
    }
    return $filename;
}

function setGradeArrayConstants($grades) {
    $gradePointsMapping = [
        'A+' => '5.0',
        'A'  => '4.5',
        'B'  => '4',
        'C'  => '3',
        'D'  => '2'
    ];
    $newConstants = [];
    foreach($grades as $constant){
        $object = new \stdClass();
        $object->grade = $constant;
        $object->point = array_key_exists($constant, $gradePointsMapping) ?
            $gradePointsMapping[$constant] : "";
        $newConstants[] = $object;
    }
    return $newConstants;
}

function fetchUrlOfImage($type) {
    $imagesFolderTypeMapping = [
        'user' => ''
    ];
}