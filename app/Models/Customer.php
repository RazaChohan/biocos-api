<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'shops';

    protected $guarded = ['id'];

    /***
     * Images of customer/shop
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany('App\Models\CustomerImage', 'shop_id');
    }
    /***
     * Get customers based on filters
     *
     * @param $userId
     * @param $regionId
     * @param $subRegion
     * @return mixed
     */
    public function getCustomers($userId, $regionId, $subRegion)
    {
        $regionIds = [];
        $regionModel = new Region();
        if(IsNullOrEmptyString($regionId)) {
            $regionIds = $regionModel->getUserRegionIds($userId);
        } else {
            $regionIds [] = $regionId;
        }
        if($subRegion == 'true') {
            $regionIds = array_merge($regionIds, $regionModel->getSubRegions($regionIds, true));
        }
        $shops = $this->with('images')
                      ->whereIn('region_id', $regionIds)
                      ->get();
        return $shops;
    }
}