<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'user_locations';
    /***
     * @var array
     */
    protected $guarded = ['id'];
    /***
     * Timestamps does not exists
     *
     * @var bool
     */
    public $timestamps = false;
    /***
     * Validation rules for add user location
     *
     * @param null $attributes
     * @return array
     */
    public function validationRules( $attributes = null )
    {
        $rules = [
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'date'      => 'required'
        ];

        // no list is provided
        if(!$attributes)
            return $rules;

        // a single attribute is provided
        if(!is_array($attributes))
            return [ $attributes => $rules[$attributes] ];

        // a list of attributes is provided
        $newRules = [];
        foreach ( $attributes as $attr )
            $newRules[$attr] = $rules[$attr];
        return $newRules;
    }

    /***
     * Insert User location
     *
     * @param $userId
     * @param $latitude
     * @param $longitude
     * @param $date
     * @return integer
     */
    public function insertUserLocation($userId, $latitude, $longitude, $date)
    {
        $model = new $this();
        $model->user_id = $userId;
        $model->latitude = $latitude;
        $model->longitude = $longitude;
        $model->date = Carbon::parse($date);
        $model->save();
        return $model->id;
    }

    /***
     * Get user locations
     *
     * @param $userId
     * @param $avoidPagination
     * @param $page
     * @return mixed
     */
    public function getUserLocations($userId, $avoidPagination, $page)
    {
        $query = $this->where('user_id', '=', $userId);
        if($page > 0 && !$avoidPagination) {
            $offset = calculate_offset($page);
            $query->skip($offset)
                ->take(10);
        }
        $locations = $query->get();
        return $locations;
    }
}