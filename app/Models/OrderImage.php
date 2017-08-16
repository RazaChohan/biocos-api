<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderImage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'order_images';
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
     * Image Attribute mutator
     * @param $value
     * @return string
     */
    public function getImageAttribute($value)
    {
        return prepend_http($value);
    }
}