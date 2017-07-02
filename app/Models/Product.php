<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'products';

    protected $guarded = ['id'];

    /***
     * Get products based on filters
     *
     * @param $agencyId
     * @return mixed
     */
    public function getProducts($agencyId)
    {
        $query = $this->whereDate('started_on', '<=', Carbon::now())
                      ->where(function($query){
                          $query->whereDate('discontinued_on', '>', Carbon::now())
                                ->orWhereNull('discontinued_on');
                      });
        if($agencyId > 0) {
            $query->where('agency_id', '=', $agencyId);
        }
        $shops =  $query->get();
        return $shops;
    }
}