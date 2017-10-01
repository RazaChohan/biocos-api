<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class JobImage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'job_images';
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