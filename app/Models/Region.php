<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Region extends Model
{

    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'regions';

    protected $guarded = ['id'];

    /***
     * Get Sub regions for a particular region
     *
     * @param $regionId
     * @param bool $getIdOnly
     */
    public function getSubRegions($regionId, $getIdOnly = false)
    {
        $query = (is_array($regionId)) ? $this->whereIn('parent_id', $regionId) :
                                         $this->where('parent_id', '=', $regionId);
        if($getIdOnly) {
            $subRegions = $query->get(['id'])->pluck('id')->toArray();
        }
        else {
            $subRegions = $query->get();
        }
        return $subRegions;
    }

    /***
     * @param $userId
     * @param $regionId
     * @param $subRegion
     * @param $avoidPagination
     * @param $page
     * @return array
     */
    public function getUserRegions($userId, $regionId, $subRegion, $avoidPagination, $page)
    {
        $regions = [];
        $regionIds = [];
        if(!IsNullOrEmptyString($regionId)) {
            $regionIds = $this->getSubRegions($regionId, true);
            array_push($regionIds, intval($regionId));
        } else if(IsNullOrEmptyString($regionId)) {
            $regionIds = DB::table('user_regions')
                            ->where('user_id', $userId)
                            ->get(['region_id'])
                            ->pluck('region_id')
                            ->toArray();
        }
        if($subRegion == 'true') {
            $regionIds = array_merge($regionIds, $this->getSubRegions($regionIds, true));
        }
        if(count($regionIds) > 0) {
            $regions = $this->whereIn('id', $regionIds);

            if($page > 0 && !$avoidPagination) {
                $offset = calculate_offset($page);
                $regions->skip($offset)
                        ->take(10);
            }
            $regions = $regions->get();
        }
        return $regions;
    }

    /***
     * get user region ids
     *
     * @param $userId
     * @return mixed
     */
    public function getUserRegionIds($userId) {
        $regionIds = DB::table('user_regions')
                        ->where('user_id', $userId)
                        ->get(['region_id'])
                        ->pluck('region_id')
                        ->toArray();
        return $regionIds;
    }
    /***
     * Validation rules for add region
     *
     * @param null $attributes
     * @return array
     */
    public function validationRules( $attributes = null )
    {
        $rules = [
            'uuid'            => 'required',
            'name'            => 'required',
            'city'            => 'required',
            'latitude'        => 'required|numeric',
            'longitude'       => 'required|numeric',
            'country'         => 'required'
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
     * Add or update region
     *
     * @param $region
     * @param int $regionId
     * @return mixed
     */
    public function addOrUpdateRegion($region, $regionId = 0)
    {
        $regionObj = new $this();
        if($regionId > 0) {
            $regionObj = $this->where('id', $regionId)
                              ->first();
            //Region not found
            if(is_null($regionObj)) {
                return $regionObj;
            }
            $regionObj->updated_by = $region['user_id'];
        } else {
            $regionObj->created_by = $region['user_id'];
            $regionObj->agency_id  = $region['agency_id'];
        }
        $regionObj->uuid       = $region['uuid'];
        $regionObj->name       = $region['name'];
        $regionObj->city       = $region['city'];
        $regionObj->latitude   = $region['latitude'];
        $regionObj->longitude  = $region['longitude'];
        $regionObj->country    = $region['country'];

        //Parent ID
        if(array_key_exists('parent_id', $region)) {
            $regionObj->parent_id = $region['parent_id'];
        }

        $regionObj->save();
        return $this->getRegionDetail($regionObj->id);
    }
    /***
     * Get Region Detail
     *
     * @param $id
     * @return mixed
     */
    public function getRegionDetail($id)
    {
        $region = $this->where('id', $id)
                       ->first();
        return $region;
    }

    /***
     * Get Region Id using uuid
     *
     * @param $uuid
     * @return integer
     */
    public function getRegionId($uuid)
    {
        $region = $this->where('uuid', $uuid)
            ->first(['id']);
        return !is_null($region) ? $region->id : 0;
    }
}
