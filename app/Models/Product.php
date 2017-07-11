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
     * @param $page
     * @return mixed
     */
    public function getProducts($agencyId, $page = 1)
    {
        $query = $this->whereDate('started_on', '<=', Carbon::now())
                      ->where(function($query){
                          $query->whereDate('discontinued_on', '>', Carbon::now())
                                ->orWhereNull('discontinued_on');
                      });
        if($agencyId > 0) {
            $query->where('agency_id', '=', $agencyId);
        }
        if($page > 0) {
            $offset = calculate_offset($page);
            $query->skip($offset)
                ->take(10);
        }
        $shops =  $query->get();
        return $shops;
    }

    /***
     * Get product detail using id
     *
     * @param $productId
     * @return mixed
     */
    public function getProductDetail($productId)
    {
        $product = $this->where('id', '=', $productId)
                        ->first();
        return $product;

    }
}