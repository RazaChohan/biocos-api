<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserRegion extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'user_regions';
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
     * Get user regions
     *
     * @param $userId
     * @param integer $regionId
     * @param integer $id
     */
    public function getUserRegions($userId, $regionId = 0, $id = 0)
    {
        $model = $this->where('user_id', $userId);
        if($id > 0) {
            $model->where('id', $id);
        }
        if($regionId > 0) {
            $model->where('region_id', $regionId);
        }
        return $model->first();
    }

    /***
     * Insert user regions
     *
     * @param $data
     * @return mixed
     */
    public function insertUserRegion($data)
    {
        $model = new $this();
        $model->fill($data);
        $model->save();
        return $model->id;
    }

    /***
     * Update user region
     *
     * @param $userRegion
     */
    public function updateUserRegion($userRegion, $updateData)
    {
        if (array_key_exists('date', $updateData)) {
            $userRegion->date = Carbon::parse($updateData['date']);
        }
        if (array_key_exists('execution_time', $updateData)) {
            $userRegion->execution_time = $updateData['execution_time'];
        }
        $userRegion->save();
    }

    /***
     * Delete User Region
     *
     * @param $id
     * @return mixed
     */
    public function deleteUserRegion($id)
    {
        return $this->where('id', '=', $id)
                    ->delete();
    }

    /***
     * Get User Region with date and region
     *
     * @param $userId
     * @param $regionId
     * @param $date
     * @return mixed
     */
    public function getUserRegionWithDateAndRegion($userId, $regionId, $date)
    {
        return $this->whereDate('date', '=', Carbon::parse($date)->toDateString())
                    ->where('region_id', '=', $regionId)
                    ->where('user_id', '=', $userId)
                    ->first();
    }
}