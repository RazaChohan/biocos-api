<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'jobs';

    protected $guarded = ['id'];

    /***
     * Get user jobs
     *
     * @param $userId
     * @param $date
     * @param $regionId
     * @param $status
     * @param $subRegion
     */
    public function getUserJobs($userId, $date, $regionId, $status, $subRegion)
    {
        $regionIds = [];
        if($subRegion == true) {
            $regionModel = new Region();
            $regionIds = $regionModel->getSubRegions($regionId, true);
            array_push($regionIds, $regionId);
        }
        $query = $this->where('user_id', '=', $userId);
        if(count($regionIds) > 0) {
            $query->whereIn('region_id', $regionIds);
        }
        else if (!IsNullOrEmptyString($regionId)) {
            $query->where('region_id', '=', $regionId);
        }
        if(!IsNullOrEmptyString($date)) {
            $query->whereDate('date', '=', $date);
        }
        if(!IsNullOrEmptyString($status)) {
            $query->where('status', '=', $status);
        }
        $jobs = $query->get();
        return $jobs;
    }
}