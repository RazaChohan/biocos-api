<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PaymentImage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'payment_images';

    protected $guarded = ['id'];

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