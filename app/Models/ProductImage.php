<?php
/**
 * Created by PhpStorm.
 * User: raza
 * Date: 8/4/17
 * Time: 1:53 AM
 */

namespace App\Models;


class ProductImage
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
}