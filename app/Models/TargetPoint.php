<?php
/**
 * Created by PhpStorm.
 * User: raza
 * Date: 10/21/17
 * Time: 11:36 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class TargetPoint extends Model
{
    /***
     * Target Points type constants
     */
    CONST ADD_PAYMENT = 'add_payment';
    CONST PLACE_ORDER = 'place_order';
    CONST CONFIRM_ORDER = 'confirm_order';
    CONST ADD_CUSTOMER = 'add_customer';
    CONST COMPLETE_JOB = 'complete_job';
    CONST ORDER_CONFIRM = 'order_confirm';
    CONST PAYMENT_ADDED = 'payment_added';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'target_points';
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
     * Get points for specific type
     *
     * @param $type
     * @return integer $points
     *
     */
    public function getTypePoints($type)
    {
        $result = $this->where('type', $type)
                       ->first(['points']);
        return is_null($result) ? $result->points : 0;
    }
}