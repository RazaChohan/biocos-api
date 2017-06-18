<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        $query = $this->where('parent_id', '=', $regionId);
        if($getIdOnly) {
            $subRegions = $query->get(['id'])->pluck('id')->toArray();
        }
        else {
            $subRegions = $query->get();
        }
        return $subRegions;
    }
}
