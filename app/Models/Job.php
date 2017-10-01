<?php

namespace App\Models;

use Carbon\Carbon;
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
     * @param $avoidPagination
     * @param $page
     *
     * @return mixed
     */
    public function getUserJobs($userId, $date, $regionId, $status, $subRegion, $avoidPagination, $page = 1)
    {
        $regionIds = [];
        if($subRegion == 'true') {
            $regionModel = new Region();
            $regionIds = $regionModel->getSubRegions($regionId, true);
            array_push($regionIds, intval($regionId));
        }
        $query = $this->with('customer')
                      ->where('user_id', '=', $userId);
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
        if($page > 0 && !$avoidPagination) {
            $offset = calculate_offset($page);
            $query->skip($offset)
                  ->take(10);
        }
        $jobs = $query->with('images')->get();
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

    /***
     * Add Job for new Customer
     *
     * @param $customer
     * @return mixed
     */
    public function addJobForNewCustomer($customer)
    {
        $newJob = new $this();
        $newJob->region_id = $customer->region_id;
        $newJob->agency_id = $customer->agency_id;
        $newJob->date      = Carbon::now();
        $newJob->customer_id = $customer->id;
        $newJob->user_id     = $customer->created_by;
        $newJob->status      = 'Completed';
        $newJob->completed_on = Carbon::now();
        $newJob->employee_location = $customer->location;
        $newJob->visit_type    = 'Visit';
        $newJob->order       = 1;
        $newJob->created_by = $customer->created_by;
        $newJob->save();
        return $this->where('id', $newJob->id)->with('images')->first();
    }

    /***
     * Customer relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }

    /***
     * Log no order
     *
     * @param $job
     * @param $userId
     *
     * @return integer $jobId
     */
    public function logNoOrder($job, $userId)
    {
        $newJob = new $this();
        $newJob = $newJob->where('customer_id', $job['customer_id'])
                         ->where('user_id', $userId)
                         ->whereIn('job_type', ['no-order', 'revisit'])
                         ->first();
        if(is_null($newJob)) {
            $newJob = new $this();
            $newJob->customer_id  = $job['customer_id'];
            $newJob->created_by   = $userId;
            $newJob->user_id      = $userId;
        }
        $newJob->job_type     = 'no-order';
        $newJob->date         = Carbon::parse($job['date'])->toDateString();
        $newJob->completed_on = Carbon::parse($job['date'])->toDateString();
        $newJob->latitude     = $job['latitude'];
        $newJob->longitude    = $job['longitude'];
        $newJob->reason       = $job['reason'];
        $newJob->region_id    = $job['region_id'];
        $newJob->comment      = $job['remarks'];
        $newJob->time         = $job['time'];
        $newJob->uuid         = $job['uuid'];
        $newJob->status       = 'Completed';
        $newJob->updated_by   = $userId;
        $newJob->save();
        //Upload or remove images
        $this->_uploadJobImage($newJob, $job);
        return $this->where('id', $newJob->id)->with('images')->first();
    }
    /***
     * Log revisit
     *
     * @param $job
     * @param $userId
     *
     * @return integer $jobId
     */
    public function logRevisit($job, $userId)
    {
        $newJob = new $this();
        $newJob = $newJob->where('customer_id', $job['customer_id'])
                         ->where('user_id', $userId)
                         ->whereIn('job_type', ['no-order', 'revisit'])
                         ->first();
        if(is_null($newJob)) {
            $newJob = new $this();
            $newJob->customer_id  = $job['customer_id'];
            $newJob->created_by   = $userId;
            $newJob->user_id      = $userId;
        }
        $newJob->date         = Carbon::parse($job['date'])->toDateString();
        if(array_key_exists('completed_on', $job)) {
            $newJob->completed_on = Carbon::parse($job['completed_on'])->toDateString();
        }
        $newJob->latitude     = $job['latitude'];
        $newJob->longitude    = $job['longitude'];
        $newJob->region_id    = $job['region_id'];
        $newJob->time         = $job['time'];
        $newJob->uuid         = $job['uuid'];
        $newJob->comment      = 'revisit';
        $newJob->job_type     = 'revisit';
        $newJob->status       = 'Completed';
        $newJob->updated_by   = $userId;
        $newJob->save();
        //Upload or remove images
        $this->_uploadJobImage($newJob, $job);
        return $this->where('id', $newJob->id)->with('images')->first();
    }
    /***
     * Images of job
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany('App\Models\JobImage', 'job_id');
    }

    /***
     * Upload Job Image
     *
     * @param $jobModel
     * @param $jobObject
     */
    private function _uploadJobImage($jobModel, $jobObject)
    {
        //Image upload
        if(array_key_exists('images', $jobObject)) {
            $images = [];
            foreach($jobObject['images'] as $image) {
                $image = upload_base64_image($image, 'uploads/job/',
                    'jobimage-');
                $jobImage = new JobImage();
                $jobImage->image = $image;
                $images[] = $jobImage;
            }
            if(count($images) > 0) {
                $jobModel->images()->saveMany($images);
            }
        }
        //Remove Image
        if(array_key_exists('remove_images', $jobObject)) {
            $jobModel->images()->whereIn('image', $jobObject['remove_images'])
                ->delete();
            foreach($jobObject['remove_images'] as $image) {
                $fileToUnlink = public_path() . '/uploads/job/' .
                    get_filename_url($image);
                if (file_exists($fileToUnlink)) {
                    unlink($fileToUnlink);
                }
            }
        }
    }
}