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
     * @return array
     */
    public function getUserRegions($userId, $regionId, $subRegion)
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
            $regions = $this->whereIn('id', $regionIds)
                            ->get();
        }
        return $regions;
    }
}
