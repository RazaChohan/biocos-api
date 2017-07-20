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
     * @param $page
     */
    public function getUserJobs($userId, $date, $regionId, $status, $subRegion, $page = 1)
    {
        $regionIds = [];
        if($subRegion == 'true') {
            $regionModel = new Region();
            $regionIds = $regionModel->getSubRegions($regionId, true);
            array_push($regionIds, intval($regionId));
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
        if($page > 0) {
            $offset = calculate_offset($page);
            $query->skip($offset)
                ->take(10);
        }
        $jobs = $query->get();
        return $jobs;
    }

    /***
     * Update Job Order
     *
     * @param $jobsToUpdate
     * @param $userId
     * @return boolean
     */
    public function updateJobOrder($jobsToUpdate, $userId)
    {
        $jobsUpdated = false;
        $jobIds = array_pluck($jobsToUpdate, 'job_id');
        $jobs = $this->whereIn('id', $jobIds)
                     ->where('user_id', $userId)
                     ->get(['id']);

        if(count($jobs) != count($jobIds)) {
            $jobsUpdated = false;
        } else {
            foreach ($jobs as $job) {
                $jobOrder = array_where($jobsToUpdate, function($value, $key) use($job) {
                    return $value['job_id'] == $job->id;
                });
                $order = array_first($jobOrder)['order'];
                $job->order = $order;
                $job->save();
                $jobsUpdated = true;
            }
        }
        return $jobsUpdated;
    }
}