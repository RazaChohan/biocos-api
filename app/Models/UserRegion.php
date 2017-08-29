<?php

namespace App\Models;


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
     * @param int $regionId
     * @return mixed
     */
    public function getUserRegions($userId, $regionId = 0)
    {
        $model = $this->where('user_id', $userId);
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
     * @param $userId
     * @param int $regionId
     * @param $updateData
     * @param $id
     */
    public function updateUserRegion($updateData, $id = 0, $userId = 0, $regionId = 0)
    {
        $model = new $this();
        if($id > 0) {
            $model->where('id', $id);
        }
        if($regionId > 0) {
            $model->where('region_id', $regionId);
        }
        if($userId > 0) {
            $model->where('user_id', $userId);
        }
        $userRegion = $model->first();
        if(count($updateData) > 0) {
            foreach ($updateData as $attribute => $value) {
                $userRegion->{$attribute} = $value;
            }
        }
        $userRegion->save();
    }
}