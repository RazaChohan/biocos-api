<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'product_images';
    /***
     * @var array
     */
    protected $guarded = ['id'];
    /***
     * Timestamp false
     *
     * @var bool
     */
    public $timestamps = false;
    /***
     * Image Attribute mutator
     *
     * @param $value
     * @return string
     */
    public function getImageAttribute($value)
    {
        return prepend_http($value);
    }
}