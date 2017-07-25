<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerImage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'shop_images';

    protected $guarded = ['id'];

    public $timestamps = false;
}